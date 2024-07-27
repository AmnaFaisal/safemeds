<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_roles', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        $permission_groups = $this->formatPermissions($permissions);
        return view('backend.roles.create', compact('permissions', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $newRole = Role::create([
                'uuid' => Str::uuid(),
                'name' => strtolower($request->name),
                'title' => ucfirst(strtolower($request->name)),
                'is_deleteable' => 1,
            ]);

            if ($request->has('permissions')) {
                $newRole->permissions()->sync($request->permissions);
            }

            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Role created successfully.',
                'redirectUrl' => route('roles.index'),
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permissions = Permission::all();
        $permission_groups = $this->formatPermissions($permissions);
        $role = Role::with('permissions')->find($id);
        return view('backend.roles.edit', compact('role', 'permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'. $id .'id',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $role = Role::findOrFail($id);

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }
            $users = $role->users;
            foreach ($users as $user) {
                $user->syncPermissions($role->permissions);
            }
            Artisan::call('optimize:clear');
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Role permissions updated successfully.',
                'redirectUrl' => route('roles.index'),
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Role deleted successfully',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function datatable(Request $request)
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        return Datatables::of($roles)
            ->addColumn('actions', function ($record) {
                $actions = '';
                if (auth()->user()->hasPermissionTo('edit_role')) {
                    $actions = '<div class="btn-list">';
                    if (auth()->user()->hasPermissionTo('edit_role')) {
                        $actions .= '<a href="' . route('roles.edit', $record->id) . '" data-title="Edit Role" class="btn btn-sm btn-primary">
                                        <span class="fe fe-edit"> </span>
                                    </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_role') && $record->is_deleteable) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('roles.destroy', $record->id) . '" data-method="get" data-table="#roles_datatable">
                                        <span class="fe fe-trash-2"> </span>
                                    </button>';
                    }
                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('title', function ($record) {
                $url = auth()->user()->hasPermissionTo('edit_role') ? route('roles.edit', $record->id) : '#';
                return '<a href="' . $url . '" class="link" data-toggle="tooltip" data-placement="top" title="Edit Role">' . $record->title . '</a>';
            })
            ->rawColumns(['title', 'actions'])
            ->addIndexColumn()->make(true);
    }
    public static function formatPermissions($permissions)
    {
        $permissionGroups = [];
        foreach ($permissions as $permission) {
            $permissionGroups[$permission->group][] = $permission;
        }
        return $permissionGroups;
    }
}
