<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Medication;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PastMedication;
use App\Models\InWardMedication;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function writePrescription()
    {
        $medications = Medication::all();
        return view('backend.prescriptions.index', compact('medications'));
    }
    public function viewPrescription($id)
    {
        $prescription = Prescription::with('patient', 'pastMedications', 'inWardMedications')->findOrFail($id);
        return view('backend.reports.view', compact('prescription'));
    }
    public function index($status)
    {
        return view('backend.reports.index', compact('status'));
    }

    public function getMedicationDetails(Request $request)
    {
        // Retrieve medication details based on the ID sent via AJAX request
        $medicationId = $request->input('medication_id');
        $medication = Medication::find($medicationId);

        // Return the medication details as JSON response
        if ($medication) {
            return response()->json([
                'name' => $medication->name,
                'dose' => $medication->dose,
                'route' => $medication->route,
                'frequency' => $medication->frequency,
                'indication' => $medication->indication,
                'discrepancy' => $medication->discrepancy,
                'resolution_plane' => $medication->resolution_plane,
            ]);
        } else {
            // Medication not found
            return response()->json(['error' => 'Medication not found'], 404);
        }
    }

    public function datatable(Request $request, $status)
    {
        $prescriptions = Prescription::with('patient')->get();
        if($status != 'all'){
            $prescriptions = $prescriptions->where('status', $status);
        }
        return Datatables::of($prescriptions)
            ->addColumn('actions', function ($record) {
                $actions = '';
                if (auth()->user()->hasPermissionTo('approve_or_reject_report')) {
                    $actions = '<div class="btn-list">
                                    <a href="' . route('prescription.show', $record->id) . '" data-title="View prescription details" class="btn btn-sm btn-info">
                                        <span class="fe fe-eye"> </span>
                                    </a>';
                    // $actions .= '
                    //                 <a data-act="ajax-modal" data-url="' . route('approve-report', [$record->id, 'accepted']) . '" class="btn btn-sm btn-success" data-bs-placement="top" data-bs-toggle="tooltip" title="Accept proposal" data-message="You want to Accept?" data-button-text="Yes! Sure" data-method="post" data-table="#proposals_datatable">
                    //                     <span class="fe fe-check-square text-white"> </span>
                    //                 </a>
                    //                 <a data-act="ajax-modal" data-url="' . route('approve-report', [$record->id, 'rejected']) . '" class="btn btn-sm btn-danger request-confirmation" data-bs-placement="top" data-bs-toggle="tooltip" title="Reject proposal" data-message="You want to Reject?" data-button-text="Yes! Sure" data-method="post" data-table="#proposals_datatable">
                    //                     <span class="fe fe-x-square text-white"> </span>
                    //                 </a>';
                    $actions .= '
                                </div>';
                }
                return $actions;
            })
            ->addColumn('name', function ($record) {
                $url = auth()->user()->hasPermissionTo('approve_or_reject_report') ? route('prescription.show', $record->id) : '#';
                return '<a href="' . $url . '" class="link" data-toggle="tooltip" data-placement="top" title="View Prescription">' . getFullName($record->patient) . '</a>';
            })
            ->addColumn('creation_date', function ($record) {
                return Carbon::parse($record->created_at)->format('d M Y');
            })
            ->addColumn('status', function ($record) {
                return '<span class="badge bg-' . statusClasses($record->status) . '">' . ucfirst($record->status) . '</span>';
            })
            ->rawColumns(['name', 'creation_date', 'status', 'actions'])
            ->addIndexColumn()->make(true);
    }

    public function updatePrescriptionStatus(Request $request, $id, $status)
    {
        if ($request->isMethod('get')) {
            return view('backend.reports.modal', compact('id'));
        }
        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->update([
                'status' => $status,
                'comment' => $request->comment,
            ]);
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Report ' . ucfirst($status)
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($id)
    {
        $medications = Medication::all();
        $prescription = Prescription::with('patient', 'pastMedications', 'inWardMedications')->findOrFail($id);
        return view('backend.reports.edit', compact('prescription', 'medications'));
    }

    public function update(Request $request, $id)
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
            $prescription = Prescription::findOrFail($id);
            $prescription->update([
                'patient_id' => $request->patientId,
                'status' => 'pending',
            ]);
            $prescription->pastMedications()->delete();
            foreach ($request->medications['past'] as $pastMedication) {
                $ommittedMed = collect($data['medications']['inWard'])
                    ->filter(function ($medication) use ($pastMedication) {
                        return $medication['med_name'] === $pastMedication['med_name'];
                    })
                    ->values()
                    ->first();
                $createdPastMed = PastMedication::create([
                    'prescription_id' => $prescription->id,
                    'name' => $pastMedication['med_name'],
                    'dose' => $pastMedication['dose'],
                    'route' => $pastMedication['route'],
                    'frequency' => $pastMedication['frequency'],
                    'indication' => $pastMedication['indication'],
                    'discrepancy' => isset($pastMedication['discrepancy']) ? 1 : 0,
                    'resolution_plane' => $pastMedication['resolution_plane'],
                ]);
                if (!isset($ommittedMed)) {
                    $createdPastMed->update([
                        'status' => 'Omission',
                    ]);
                }
            }
            $prescription->inWardMedications()->delete();
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
                    if ((float)$inWardMedication['dose'] == (float)$committedMed['dose']) {
                        $createdInWardMed->update([
                            'status' => 'Appropriate Dosage',
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => JsonResponse::HTTP_OK,
                'message' => 'Prescription updated successfully.',
                // 'redirectUrl' => route(),
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
