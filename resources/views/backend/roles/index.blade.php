@extends('backend.layouts.app')

@section('title', '| Roles')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Roles List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roles</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Roles</h3>
            {{-- <a href="{{ route('roles.create') }}" class="btn dark-icon btn-primary" data-method="get"
                data-title="Add New User">
                <i class="ri-add-fill"></i> Add Role
            </a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="roles_datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">ID</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Action</th>
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
            $('#roles_datatable').DataTable({
                ajax: '{{ route('roles-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                columnDefs: [{
                        width: 1,
                        targets: 2
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
                        data: 'title',
                        name: 'title'
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
