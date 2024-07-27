@extends('backend.layouts.app')

@section('title', '| Edit Prescription')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title"> Edit Prescription</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Prescription</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @php
        $pastMedicationsCount = $prescription->pastMedications->count();
        $inWardMedicationsCount = $prescription->inWardMedications->count();
    @endphp
    <form class="medicationForm" action="{{ route('reports.update', $prescription->id) }}" method="post" id="medicationForm" data-form="ajax-form">
        @csrf
        @method('put')
        <div class="card">
            <div class="card-header justify-content-between">
                <div class="d-flex">
                    <h3 class="card-title font-weight-bold me-2">Patient Details</h3>
                    <span class="badge bg-{{ statusClasses($prescription->status) }}">{{ ucfirst($prescription->status) }}</span>
                </div>
                <a href="{{ route('reports.index', $prescription->status) }}" class="btn btn-sm dark-icon btn-primary" data-method="get" data-title="Back">
                    <i class="fe fe-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                @if ($prescription->status == 'rejected')
                    <div class="alert alert-danger" role="alert">
                        {{ $prescription->comment }}
                    </div>
                @endif
                <div id="selectedPatientInfo" class="px-3 mt-4">
                <input type="hidden" name="patientId" value="{{ $prescription->patient->id }}"/>
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
                <button type="button" id="addPastRowBtn" class="btn dark-icon btn-primary btn-sm">
                    <i class="ri-add-fill"></i> Add Medication
                </button>
            </div>
        <div class="card-body pb-0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th></th>
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
                    @foreach ($prescription->pastMedications as $pastMedication)
                        <tr id="past_row_{{ $loop->index }}">
                            <td class="align-content-center"><button type="button" class="btn btn-sm btn-danger delete-row" data-id="#past_row_{{ $loop->index }}"><span class="fe fe-trash-2"> </span></button></td>
                            <td>
                                <select class="form-select select2 medication_name" name="medications[past][{{ $loop->index }}][medication_name]">
                                    <option value="" selected disabled>Select Medication</option>
                                    @foreach ($medications as $medication)
                                        <option value="{{ $medication->id }}" @if ($medication->name == $pastMedication->name) selected @endif>{{ $medication->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="hidden" class="med_name" name="medications[past][{{ $loop->index }}][med_name]" value="{{ $pastMedication->name }}">
                                <input type="number" min="0" step="0.1" class="form-control dose" name="medications[past][{{ $loop->index }}][dose]" value="{{ $pastMedication->dose }}"></td>
                            <td><input type="text" class="form-control route" name="medications[past][{{ $loop->index }}][route]" value="{{ $pastMedication->route }}"></td>
                            <td><input type="text" class="form-control frequency" name="medications[past][{{ $loop->index }}][frequency]" value="{{ $pastMedication->frequency }}"></td>
                            <td><input type="text" class="form-control indication" name="medications[past][{{ $loop->index }}][indication]" value="{{ $pastMedication->indication }}"></td>
                            <td class="align-content-center">
                                <label class="custom-control custom-checkbox mb-0 ms-3">
                                    <input type="checkbox" class="custom-control-input" name="medications[past][{{ $loop->index }}][discrepancy]" @if ($pastMedication->discrepancy == 1) checked @endif>
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td><input type="text" class="form-control resolution_plane" name="medications[past][{{ $loop->index }}][resolution_plane]" value="{{ $pastMedication->resolution_plane }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <hr>
            <div class="card-header justify-content-between" style="border-top: 1px solid #e9edf4;">
                <h6 class="card-title font-weight-bold">In-Ward Medications</h6>
                <button type="button" id="addInWardRowBtn" class="btn dark-icon btn-primary btn-sm">
                    <i class="ri-add-fill"></i> Add Medication
                </button>
            </div>
            <div class="card-body">
                <table id="inWardMedicationTable" class="table table-responsive">
                    <thead style="display:none;" id="inWardMedicationTableHeadings">
                        <tr>
                            <th></th>
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
                        @foreach ($prescription->inWardMedications as $inWardMedication)
                            <tr id="inWard_row_{{ $loop->index }}">
                                <td class="align-content-center"><button type="button" class="btn btn-sm btn-danger delete-row" data-id="#inWard_row_{{ $loop->index }}"><span class="fe fe-trash-2"> </span></button></td>
                                <td>
                                    <select class="form-select select2 medication_name" name="medications[inWard][{{ $loop->index }}][medication_name]">
                                        <option value="" selected disabled>Select Medication</option>
                                        @foreach ($medications as $medication)
                                            <option value="{{ $medication->id }}" @if ($medication->name == $inWardMedication->name) selected @endif>{{ $medication->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="hidden" class="med_name" name="medications[inWard][{{ $loop->index }}][med_name]" value="{{ $inWardMedication->name }}">
                                    <input type="number" min="0" step="0.1" class="form-control dose" name="medications[inWard][{{ $loop->index }}][dose]" value="{{ $inWardMedication->dose }}"></td>
                                <td><input type="text" class="form-control route" name="medications[inWard][{{ $loop->index }}][route]" value="{{ $inWardMedication->route }}"></td>
                                <td><input type="text" class="form-control frequency" name="medications[inWard][{{ $loop->index }}][frequency]" value="{{ $inWardMedication->frequency }}"></td>
                                <td><input type="text" class="form-control indication" name="medications[inWard][{{ $loop->index }}][indication]" value="{{ $inWardMedication->indication }}"></td>
                                <td class="align-content-center">
                                    <label class="custom-control custom-checkbox mb-0 ms-3">
                                        <input type="checkbox" class="custom-control-input" name="medications[inWard][{{ $loop->index }}][discrepancy]" @if ($inWardMedication->discrepancy == 1) checked @endif>
                                        <span class="custom-control-label"></span>
                                    </label>
                                </td>
                                <td><input type="text" class="form-control resolution_plane" name="medications[inWard][{{ $loop->index }}][resolution_plane]" value="{{ $inWardMedication->resolution_plane }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-lg-12 px-0 my-3">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        var counter = '{{ $pastMedicationsCount }}';
        var count = '{{ $inWardMedicationsCount }}';

        $('#addPastRowBtn').click(function() {
            counter++;
            var newRow = `
                <tr id="past_row_${counter}">
                    <td class="align-content-center"><button type="button" class="btn btn-sm btn-danger delete-row" data-id="#past_row_${counter}"><span class="fe fe-trash-2"> </span></button></td>
                    <td>
                        <select class="form-select select2 medication_name" name="medications[past][${counter}][medication_name]">
                            <option value="" selected disabled>Select Medication</option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="hidden" class="med_name" name="medications[past][${counter}][med_name]">
                        <input type="text" class="form-control dose" name="medications[past][${counter}][dose]"></td>
                    <td><input type="text" class="form-control route" name="medications[past][${counter}][route]"></td>
                    <td><input type="text" class="form-control frequency" name="medications[past][${counter}][frequency]"></td>
                    <td><input type="text" class="form-control indication" name="medications[past][${counter}][indication]"></td>
                    <td class="align-content-center">
                        <label class="custom-control custom-checkbox mb-0 ms-3">
                            <input type="checkbox" class="custom-control-input" name="medications[past][${counter}][discrepancy]">
                            <span class="custom-control-label"></span>
                        </label>
                    </td>
                    <td><input type="text" class="form-control resolution_plane" name="medications[past][${counter}][resolution_plane]"></td>
                </tr>
             `;
            $('#pastMedicationTable tbody').append(newRow);
            $('#pastMedicationTableHeadings').show();
            $('#submitBtn').show();
            $('.select2').select2();
            $('.select2-container').css('min-width', '225px');
            $('input').css('width', 'auto');
        });

        $('#addInWardRowBtn').click(function() {
            count++;
            var newRow = `
                <tr id="inWard_row_${count}">
                    <td class="align-content-center"><button type="button" class="btn btn-sm btn-danger delete-row" data-id="#inWard_row_${count}"><span class="fe fe-trash-2"> </span></button></td>
                    <td>
                        <select class="form-select select2 medication_name" name="medications[inWard][${count}][medication_name]">
                            <option value="" selected disabled>Select Medication</option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="hidden" class="med_name" name="medications[inWard][${count}][med_name]">
                        <input type="text" class="form-control dose" name="medications[inWard][${count}][dose]"></td>
                    <td><input type="text" class="form-control route" name="medications[inWard][${count}][route]"></td>
                    <td><input type="text" class="form-control frequency" name="medications[inWard][${count}][frequency]"></td>
                    <td><input type="text" class="form-control indication" name="medications[inWard][${count}][indication]"></td>
                    <td class="align-content-center">
                        <label class="custom-control custom-checkbox mb-0 ms-3">
                            <input type="checkbox" class="custom-control-input" name="medications[inWard][${count}][discrepancy]">
                            <span class="custom-control-label"></span>
                        </label>
                    </td>
                    <td><input type="text" class="form-control resolution_plane" name="medications[inWard][${count}][resolution_plane]"></td>
                </tr>
             `;
            $('#inWardMedicationTable tbody').append(newRow);
            $('#inWardMedicationTableHeadings').show();
            $('#submitBtn').show();
            $('.select2').select2();
            $('.select2-container').css('min-width', '225px');
            $('input').css('width', 'auto');
        });

        $(document).on('click', '.delete-row', function() {
            var rowId = $(this).data('id');
            $(rowId).remove();

            if ($('#pastMedicationTable tbody tr').length === 0) {
                $('#pastMedicationTableHeadings').hide();
            }

            if ($('#inWardMedicationTable tbody tr').length === 0) {
                $('#inWardMedicationTableHeadings').hide();
            }
            if ($('#pastMedicationTable tbody tr').length === 0 && $('#inWardMedicationTable tbody tr').length === 0) {
                $('#submitBtn').hide();
            }
        });

        $(document).on('change', '.medication_name', function() {
            var rowId = $(this).closest('tr').attr('id');
            var medicationId = $(this).val();

            $.ajax({
                url: '/getMedicationDetails',
                method: 'GET',
                data: {
                    medication_id: medicationId
                },
                success: function(response) {
                    $('#' + rowId + ' .med_name').val(response.name);
                    $('#' + rowId + ' .dose').val(response.dose);
                    $('#' + rowId + ' .route').val(response.route);
                    $('#' + rowId + ' .frequency').val(response.frequency);
                    $('#' + rowId + ' .indication').val(response.indication);
                    $('#' + rowId + ' .discrepancy').val(response.discrepancy);
                    $('#' + rowId + ' .resolution_plane').val(response.resolution_plane);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $(document).ready(function() {
            var cardCount = 0;
            var medicationCount = 0;

            $('#searchInput').keyup(function(event) {
                const searchTerm = $(this).val();
                if (searchTerm.trim() !== '') {
                    $.ajax({
                        url: '{{ route('search.patients') }}',
                        method: 'GET',
                        data: {
                            searchInput: searchTerm
                        },
                        success: function(response) {
                            displaySearchResults(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#searchResults').hide();
                }
            });

            function displaySearchResults(results) {
                $('#searchResults').empty();
                if (results.length) {
                    $.each(results, function(index, patient) {
                        var $dropdownItem = $('<a class="dropdown-item px-0" href="#" data-id="' + patient.id +
                            '">' + patient.first_name + ' ' + patient.last_name + '</a>');
                        $dropdownItem.click(function(event) {
                            event.stopPropagation();
                            displaySelectedPatient(patient);
                            $('#addCardForm').show();
                            $('#searchResults').hide();
                        });
                        $('#searchResults').append($dropdownItem);
                    });
                } else {
                    $('#searchResults').html('No results Found');
                }
                $('#searchResults').show();
            }

            function displaySelectedPatient(patient) {
                var patientInfo = `
                <input type="hidden" name="patientId" value="${patient.id}"/>
                <div style="display: flex; flex-direction: column;">
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Patient ID:</span>
                        <span style="flex: 1;">${patient.patient_id}</span>
                        <span style="width: 150px; font-weight: bold;">First Name:</span>
                        <span style="flex: 1;">${patient.first_name}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Last Name:</span>
                        <span style="flex: 1;">${patient.last_name}</span>
                        <span style="width: 150px; font-weight: bold;">Date of Birth:</span>
                        <span style="flex: 1;">${patient.date_of_birth}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Gender:</span>
                        <span style="flex: 1;">${patient.gender}</span>
                        <span style="width: 150px; font-weight: bold;">Age:</span>
                        <span style="flex: 1;">${patient.age}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Blood Group:</span>
                        <span style="flex: 1;">${patient.blood_group}</span>
                        <span style="width: 150px; font-weight: bold;">Primary Care Physician:</span>
                        <span style="flex: 1;">${patient.primary_care_physician}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Number:</span>
                        <span style="flex: 1;">${patient.contact_number}</span>
                        <span style="width: 150px; font-weight: bold;">Address:</span>
                        <span style="flex: 1;">${patient.address}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Marital Status:</span>
                        <span style="flex: 1;">${patient.marital_status}</span>
                        <span style="width: 150px; font-weight: bold;">Allergic:</span>
                        <span style="flex: 1;">${patient.allergic}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Past Surgeries:</span>
                        <span style="flex: 1;">${patient.past_surgeries}</span>
                        <span style="width: 150px; font-weight: bold;">Past Illness:</span>
                        <span style="flex: 1;">${patient.past_illness}</span>
                    </div>
                    <div style="display: flex; margin-bottom: 10px;">
                        <span style="width: 150px; font-weight: bold;">Patient Diagnose:</span>
                        <span style="flex: 1;">${patient.patient_diagnose}</span>
                    </div>
                </div>`;
                $('#selectedPatientInfo').html(patientInfo);
            }
        });
    </script>
@endpush
