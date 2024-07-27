@extends('backend.layouts.app')

@section('title', '| Edit Role')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Roles List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $role->title }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Edit Role</h3>
            <a href="{{ route('roles.index') }}" class="btn btn-sm dark-icon btn-primary" data-method="get" data-title="Back">
                <i class="fe fe-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            @include('backend.roles.form')
        </div>
    </div>
@endsection