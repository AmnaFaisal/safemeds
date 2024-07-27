@php
    $isEdit = isset($user) ? true : false;
    $url = $isEdit ? route('users.update', $user->id) : route('users.store');

@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax_model" data-datatable="#users_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="first_name">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="{{$isEdit ? $user->first_name : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="last_name">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="{{$isEdit ? $user->last_name : ''}}">
        </div>

        <div class="form-group col-lg-6">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="email" value="{{$isEdit ? $user->email : ''}}">
        </div>
        <div class="form-group col-lg-6">
            <label for="phone">Phone</label>
            <input type="number" class="form-control" name="phone" id="phone" value="{{$isEdit ? $user->phone : ''}}">
        </div>

        <div class="form-group col-lg-6">
            <label for="password">Password <span class="text-danger">* <small>@if($isEdit) (Leave blank if you don't wanna change password.) @endif</small></span></label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="form-group col-lg-6">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
        </div>
        <div class="form-group col-lg-6">
            <label for="role">Role</label>
            <select class="form-control select2 form-select form-select-modal" name="role" id="role">
                <option value="" selected disabled> --- Select Role --- </option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" @if ($isEdit && $role->name == $user->user_type) selected @endif>{{ $role->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="status">Status</label>
            <select class="form-control select2 form-select form-select-modal" name="status" id="status">
                <option value="active" @if ($isEdit && $user->status == 'active') selected @endif>Active</option>
                <option value="inactive" @if ($isEdit && $user->status == 'inactive') selected @endif>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12 px-0">
        <button type="submit" class="btn btn-primary" data-button="submit">Submit</button>
    </div>
</form>
