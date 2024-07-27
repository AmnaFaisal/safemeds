@extends('backend.layouts.app')

@section('title', '| View Prescription')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title"> View Prescription</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Prescription</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <div class="d-flex">
                <h3 class="card-title font-weight-bold me-2">Patient Details</h3>
                <span class="badge bg-{{ statusClasses($prescription->status) }}">{{ ucfirst($prescription->status) }}</span>
            </div>
            <div>
                @can('approve_or_reject_report')
                    @if($prescription->status == 'pending')
                        <a class="btn btn-sm dark-icon btn-success request-confirmation text-white" data-message="You want to approve?" data-button-text="Yes" data-method="post" data-url="{{ route('update-report-status', [$prescription->id, 'approved']) }}" data-title="Approve" data-refresh="true">
                            <i class="fe fe-check"></i> Approve
                        </a>
                        <button type="button" class="btn dark-icon btn-danger btn-sm" data-act="ajax-modal" data-method="get" data-action-url="{{ route('update-report-status', [$prescription->id, 'rejected']) }}" data-title="Reject Report">
                            <i class="fe fe-x-circle"></i> Reject
                        </button>
                    @endif
                @endcan
                @can('write_prescription')
                    @if($prescription->status == 'rejected')
                        <a href="{{ route('reports.edit', $prescription->id) }}" class="btn btn-sm dark-icon btn-primary" data-method="get" data-title="Edit">
                            <i class="fe fe-edit"></i> Edit
                        </a>
                    @endif
                @endcan
                <a href="{{ route('reports.index', $prescription->status) }}" class="btn btn-sm dark-icon btn-primary" data-method="get" data-title="Back">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            @if ($prescription->status == 'rejected')
                <div class="alert alert-danger" role="alert">
                    {{ $prescription->comment }}
                </div>
            @endif
            <div id="selectedPatientInfo" class="px-3">
                <div style="display: flex; flex-direction: column;">
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Patient ID:</span>
                        <span style="flex: 1;">{{ $prescription->patient->patient_id }}</span>
                        <span style="width: 150px; font-weight: bold;">First Name:</span>
                        <span style="flex: 1;">{{ $prescription->patient->first_name }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Last Name:</span>
                        <span style="flex: 1;">{{ $prescription->patient->last_name }}</span>
                        <span style="width: 150px; font-weight: bold;">Date of Birth:</span>
                        <span style="flex: 1;">{{ $prescription->patient->date_of_birth }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Gender ID:</span>
                        <span style="flex: 1;">{{ $prescription->patient->gender }}</span>
                        <span style="width: 150px; font-weight: bold;">Age:</span>
                        <span style="flex: 1;">{{ $prescription->patient->age }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Blood Group:</span>
                        <span style="flex: 1;">{{ $prescription->patient->blood_group }}</span>
                        <span style="width: 150px; font-weight: bold;">Primary Care Physician:</span>
                        <span style="flex: 1;">{{ $prescription->patient->primary_care_physician }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Number:</span>
                        <span style="flex: 1;">{{ $prescription->patient->contact_number }}</span>
                        <span style="width: 150px; font-weight: bold;">Address:</span>
                        <span style="flex: 1;">{{ $prescription->patient->address }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Marital Status:</span>
                        <span style="flex: 1;">{{ $prescription->patient->marital_status }}</span>
                        <span style="width: 150px; font-weight: bold;">Allergic:</span>
                        <span style="flex: 1;">{{ $prescription->patient->allergic }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Past Surgeries:</span>
                        <span style="flex: 1;">{{ $prescription->patient->past_surgeries }}</span>
                        <span style="width: 150px; font-weight: bold;">Past Illness:</span>
                        <span style="flex: 1;">{{ $prescription->patient->past_illness }}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Patient Diagnose:</span>
                        <span style="flex: 1;">{{ $prescription->patient->patient_diagnose }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header justify-content-between">
            <h6 class="card-title font-weight-bold">Past Medications</h6>
        </div>
        <div class="card-body">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Dose(mg)</th>
                        <th>Route</th>
                        <th>Frequency</th>
                        <th>Indication</th>
                        <th>Discrepancy</th>
                        <th>Resolution</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prescription->pastMedications as $pastMedication)
                        <tr>
                            <td class="@if (in_array($pastMedication->status, ['Omission', 'Over Dosage'])) text-danger @else text-success @endif">{{ $pastMedication->status }}</td>
                            <td>{{ $pastMedication->name }}</td>
                            <td>{{ $pastMedication->dose }}</td>
                            <td>{{ $pastMedication->route }}</td>
                            <td>{{ $pastMedication->frequency }}</td>
                            <td>{{ $pastMedication->indication }}</td>
                            <td>
                                <label class="custom-control custom-checkbox mb-0 ms-3">
                                    <input type="checkbox" class="custom-control-input" name="medications[past][${counter}][discrepancy]" @if ($pastMedication->discrepancy) checked @endif disabled>
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td>{{ $pastMedication->resolution_plane }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Record Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header justify-content-between" style="border-top: 1px solid #e9edf4;">
            <h6 class="card-title font-weight-bold">In-Ward Medications</h6>
        </div>
        <div class="card-body">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Dose(mg)</th>
                        <th>Route</th>
                        <th>Frequency</th>
                        <th>Indication</th>
                        <th>Discrepancy</th>
                        <th>Resolution</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prescription->inWardMedications as $inWardMedication)
                        <tr>
                            <td class="@if (in_array($inWardMedication->status, ['Commission', 'Under Dosage', 'Appropriate Dosage'])) text-success @else text-danger @endif">{{ $inWardMedication->status }}</td>
                            <td>{{ $inWardMedication->name }}</td>
                            <td>{{ $inWardMedication->dose }}</td>
                            <td>{{ $inWardMedication->route }}</td>
                            <td>{{ $inWardMedication->frequency }}</td>
                            <td>{{ $inWardMedication->indication }}</td>
                            <td>
                                <label class="custom-control custom-checkbox mb-0 ms-3">
                                    <input type="checkbox" class="custom-control-input" name="medications[inWard][${counter}][discrepancy]" @if ($inWardMedication->discrepancy) checked @endif disabled>
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td>{{ $inWardMedication->resolution_plane }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Record Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12 px-0 my-3">
        <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none;">Submit</button>
    </div>
@endsection