@extends('backend.layouts.app')

@section('title', '| Patients')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Patients List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Patients</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Patients</h3>
            @can('add_patient')
                <button type="button" class="btn dark-icon btn-primary btn-sm" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('patients.create') }}" data-title="Add New Patient">
                    <i class="ri-add-fill"></i> Add Patient
                </button>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="patients_datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Patient ID</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Date of Birth</th>
                            <th class="border-bottom-0">Phone</th>
                            {{-- <th class="border-bottom-0">Status</th> --}}
                            <th class="border-bottom-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#patients_datatable').DataTable({
                ajax: '{{ route('patients-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columnDefs: [{
                        width: 1,
                        targets: 5
                    },
                    {
                        width: '5%',
                        targets: 0
                    }
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'patient_id',
                        name: 'patient_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'date_of_birth',
                        name: 'date_of_birth'
                    },
                    {
                        data: 'contact_number',
                        name: 'contact_number'
                    },
                    // {
                    //     data: 'status',
                    //     name: 'status'
                    // },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
