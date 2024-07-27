<?php

namespace App\Http\Controllers\Backend;

use App\Models\InWardMedication;
use App\Models\PastMedication;
use App\Models\Patient;
use App\Models\Medication;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;


class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('backend.prescriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.prescriptions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();
            $medications = Medication::create([
                'patient_id' => $request->patient_id,
                'dose' => $request->dose,
                'route' => $request->route,
                'frequency' => $request->frequency,
                'indication' => $request->indication,
                'discrepancy' => $request->frequency,
                'resolution_plane' => $request->indication,
                'status' => $request->status,
            ]);

            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Medication created successfully.',
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $medications = Medication::findOrFail($id);
            $medications->delete();
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
    public function search(Request $request)
    {
        $searchTerm = $request->input('searchInput');
        $patients = Patient::where('first_name', 'like', "%$searchTerm%")
            ->orWhere('last_name', 'like', "%$searchTerm%")
            ->orWhere('patient_id', 'like', "%$searchTerm%")
            ->get();
        return response()->json($patients);
    }

    public function medicationForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patientId' => 'required',
            'medications.past.*.med_name' => 'required|distinct',
            'medications.inWard' => 'required|array',
            'medications.inWard.*.med_name' => 'required|distinct',
        ], [
            'patientId.required' => 'Please select a patient',
            'medications.past.*.med_name.required' => 'Select a value for all added past medication',
            'medications.past.*.med_name.distinct' => 'Duplicate selection in past medications.',
            'medications.inWard.required' => 'In-Ward medications are required',
            'medications.inWard.*.med_name.required' => 'Select a value for all added in-ward medication',
            'medications.inWard.*.med_name.distinct' => 'Duplicate selection in in-ward medications.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data = $request->all();
        try {
            DB::beginTransaction();
            $prescription = Prescription::create([
                'patient_id' => $request->patientId,
                'status' => 'pending',
            ]);
            foreach ($request->medications['past'] as $pastMedication) {
                $ommittedMed = collect($data['medications']['inWard'])
                    ->filter(function ($medication) use ($pastMedication) {
                        return $medication['med_name'] === $pastMedication['med_name'];
                    })
                    ->values()
                    ->first();
                $createdPastMed =PastMedication::create([
                    'prescription_id' => $prescription->id,
                    'name' => $pastMedication['med_name'],
                    'dose' => $pastMedication['dose'],
                    'route' => $pastMedication['route'],
                    'frequency' => $pastMedication['frequency'],
                    'indication' => $pastMedication['indication'],
                    'discrepancy' => isset($pastMedication['discrepancy']) ? 1 : 0,
                    'resolution_plane' => $pastMedication['resolution_plane'],
                ]);
                if(!isset($ommittedMed)){
                    $createdPastMed->update([
                        'status' => 'Omission',
                    ]);
                }
            }
            foreach ($request->medications['inWard'] as $inWardMedication) {
                $committedMed = collect($data['medications']['past'])
                    ->filter(function ($medication) use ($inWardMedication) {
                        return $medication['med_name'] === $inWardMedication['med_name'];
                    })
                    ->values()
                    ->first();
                $createdInWardMed = InWardMedication::create([
                    'prescription_id' => $prescription->id,
                    'name' => $inWardMedication['med_name'],
                    'dose' => $inWardMedication['dose'],
                    'route' => $inWardMedication['route'],
                    'frequency' => $inWardMedication['frequency'],
                    'indication' => $inWardMedication['indication'],
                    'discrepancy' => isset($inWardMedication['discrepancy']) ? 1 : 0,
                    'resolution_plane' => $inWardMedication['resolution_plane'],
                ]);
                if (!isset($committedMed)) {
                    $createdInWardMed->update([
                        'status' => 'Commission',
                    ]);
                } else {
                    if ((float)$inWardMedication['dose'] > (float)$committedMed['dose']) {
                        $createdInWardMed->update([
                            'status' => 'Over Dosage',
                        ]);
                    } else {
                        $createdInWardMed->update([
                            'status' => 'Under Dosage',
                        ]);
                    }
                    if ((float) $inWardMedication['dose'] == (float) $committedMed['dose']) {
                        $createdInWardMed->update([
                            'status' => 'Appropriate Dosage',
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Prescription created successfully.',
                // 'redirectUrl' => route(),
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
