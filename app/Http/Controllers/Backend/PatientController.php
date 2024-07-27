<?php

namespace App\Http\Controllers\Backend;

use App\Models\Patient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        return view('backend.patients.index');
    }

    public function create()
    {
        $patientId = Setting::where('key', 'patient_id')->first()->value;
        return view('backend.patients.modal' , compact('patientId'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'blood_group' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'patient_diagnose' => 'required',
            'primary_care_physician' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();
            $patientIdSetting = Setting::where('key', 'patient_id')->first();

            $patient = Patient::create([
                'patient_id' => $patientIdSetting->value,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'patient_diagnose' => $request->patient_diagnose,
                'past_illness' => $request->past_illness,
                'past_surgeries' => $request->past_surgeries,
                'allergic' => $request->allergic,
                'primary_care_physician' => $request->primary_care_physician,
                'status' => $request->status,
            ]);

            // Update patient_id in Setting table
            $min_length = 4;
            $formatted_number = str_pad($patientIdSetting->value + 1, max($min_length, strlen((string)$patientIdSetting->value + 1)), '0', STR_PAD_LEFT);
            $patientIdSetting->update(['value' => $formatted_number]);

            DB::commit();

            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Patient created successfully.',
                // 'redirectUrl' => route('patients.edit', $patient->id),
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {

        $patientId = Setting::where('key', 'patient_id')->first()->value;
        $patient = Patient::findOrFail($id);
        return view('backend.patients.modal', compact('patient', 'patientId'));
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'blood_group' => 'required',
            'marital_status' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'patient_diagnose' => 'required',
            'primary_care_physician' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            DB::beginTransaction();

            $patient = Patient::findOrFail($id);
            $patient->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'patient_diagnose' => $request->patient_diagnose,
                'past_illness' => $request->past_illness,
                'past_surgeries' => $request->past_surgeries,
                'allergic' => $request->allergic,
                'primary_care_physician' => $request->primary_care_physician,
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Patient updated successfully.',
            ], JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy(string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Patient deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function dataTable(Request $request)
    {
        $patients = Patient::get();

        return DataTables::of($patients)
            ->addColumn('actions', function ($record) {
                $actions = '';
                if (auth()->user()->hasPermissionTo('edit_user') || auth()->user()->hasPermissionTo('delete_user')) {
                    $actions = '<div class="btn-list">';
                    if (auth()->user()->hasPermissionTo('edit_user')) {
                        $actions .= '<a data-act="ajax-modal" data-action-url="' . route('patients.edit', $record->id) . '" title="Edit Patient" class="btn btn-sm btn-primary">
                                            <span class="fe fe-edit"> </span>
                                        </a>';
                    }
                    if (auth()->user()->hasPermissionTo('delete_user')) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger delete" data-url="' . route('patients.destroy', $record->id) . '" data-method="get" data-table="#patients_datatable" title="Delete Patent">
                                            <span class="fe fe-trash-2"></span>
                                        </button>';
                    }
                    $actions .= '</div>';
                }
                return $actions;
            })
            ->addColumn('name', function ($record) {
                $route = auth()->user()->hasPermissionTo('edit_patient') ? route('patients.edit', $record->id) : '#';
                return '<a href="javascript:void(0)" data-act="ajax-modal" data-action-url="' . $route . '" class="link" data-toggle="tooltip" data-placement="top" data-title="Edit Patient">' . getFullName($record) . '</a>';
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
            })
            ->rawColumns(['name', 'status', 'actions', 'patient_id'])
            ->addIndexColumn()
            ->make();
    }
}
