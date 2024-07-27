@extends('backend.layouts.app')

@section('title', '| Edit Patient')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Edit Patient</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $patient->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Edit Patient</h3>
            <a href="{{ route('patients.index') }}" class="btn btn-sm dark-icon btn-primary" data-method="get" data-title="Back">
                <i class="fe fe-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            @include('backend.patients.modal')
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <!-- COL-END -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li><a href="#policies_tab" class="active" data-bs-toggle="tab">Policy Details</a></li>
                                    <li><a href="#client_details_tab" data-bs-toggle="tab">Client Details</a></li>
                                    @can('view_notices')
                                        <li><a href="#noticies_tab" data-bs-toggle="tab">Notices & Files</a></li>
                                    @endcan
                                    @can('perform_manual_payment')
                                        <li><a href="#payments_tab" data-bs-toggle="tab">Payments</a></li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body pb-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="policies_tab">
                                    <div class="col-xl-12 px-0">
                                        @include('backend.client-policies.policies_tab')
                                    </div>
                                </div>
                                <div class="tab-pane" id="client_details_tab">
                                    <div class="col-xl-12 px-0">
                                        @include('backend.client-policies.client_details_tab')
                                    </div>
                                </div>
                                @can('view_notices')
                                    <div class="tab-pane" id="noticies_tab">
                                        <div class="col-xl-12 px-0">
                                            @include('backend.client-policies.notices.index')
                                        </div>
                                    </div>
                                @endcan
                                @can('perform_manual_payment')
                                    <div class="tab-pane" id="payments_tab">
                                        <div class="col-xl-12 px-0">
                                            @include('backend.client-policies.payments.index')
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL-END -->
    </div>
    @push('scripts')
        <!-- SHOW PASSWORD JS -->
        <script src="{{ asset('backend/js/show-password.min.js') }}"></script>
    @endpush
@endsection
