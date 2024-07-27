@extends('backend.layouts.app')

@section('title', '| Medicaion')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Medications List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Medication</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Medications</h3>
            @can('add_user')
                <button type="button" class="btn dark-icon btn-primary" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('medications.create') }}" data-title="Add New Medication">
                    <i class="ri-add-fill"></i> Add Medication
                </button>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="medications_datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Medication Name</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Phone</th>
                            <th class="border-bottom-0">Status</th>
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
            $('#medications_datatable').DataTable({
                ajax: '{{ route('medications-datatable') }}',
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
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
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
