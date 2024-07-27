@extends('backend.layouts.app')

@section('title', '| Reports')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Reports List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">{{ ucfirst($status) }} Reports</h3>
            {{-- <a href="{{ route('reports.create') }}" class="btn dark-icon btn-primary" data-method="get"
                data-title="Add New User">
                <i class="ri-add-fill"></i> Add Role
            </a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="reports_datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">ID</th>
                            <th class="border-bottom-0">Patient Name</th>
                            <th class="border-bottom-0">Creation Date</th>
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
            $('#reports_datatable').DataTable({
                ajax: '{{ route('reports-datatable', $status) }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                columnDefs: [{
                        width: 1,
                        targets: 4
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'creation_date',
                        name: 'creation_date'
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
                ],
            });
        });
    </script>
@endpush
