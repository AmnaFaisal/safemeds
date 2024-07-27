@php
    $isEdit = isset($role) ? true : false;
    $url = $isEdit ? route('roles.update', $role->id) : route('roles.store');
    $rolePermissions = $isEdit ? $role->permissions?->pluck('id')->toArray() : [];
@endphp

<form action="{{ $url }}" method="post" data-form="ajax-form" data-redirect='true'>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row g-4">
        <div class="col-lg-9">
            <div class="form-group">
                <label class="form-label" for="role_name">Role Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Role Name" required value="{{ $isEdit ? $role->title : '' }}" {{ $isEdit ? 'readonly' : '' }}>
                </div>
            </div>
        </div>
        <div class="align-self-end col-lg-3 align-self-center">
            <div class="custom-control custom-control-md custom-checkbox custom-control">
                <input type="checkbox" class="custom-control-input assign-all" id="assign_all"
                    @if ($isEdit && count($permissions) === count($rolePermissions)) checked @endif>
                <label class="custom-control-label text-capitalize" for="assign_all">Assign all permissions</label>
            </div>
        </div>
    </div>
    <div class="row g-4">
        @foreach ($permission_groups as $key => $permissions)
            <div class="col-lg-3">
                <h6 class="text-capitalize form-label">{{ ucwords(formatString($key)) }}</h6>
                <div class="custom-control custom-control-md custom-checkbox custom-control pb-2">
                    <input type="checkbox" class="custom-control-input group-permissions" id="{{ $key }}" @if ($isEdit && count($permissions) == getAssignedPermissionsCount($role, $key)) checked @endif />
                    <label class="custom-control-label text-capitalize" for="{{ $key }}">Select all</label>
                </div>
                @foreach ($permissions as $permission)
                    <div class="custom-control custom-control-md custom-checkbox custom-control pb-2">
                        <input type="checkbox" class="custom-control-input permission-checkbox" value="{{ $permission->id }}" id="{{ $permission->id }}" name="permissions[]" @if ($isEdit && $role->hasPermissionTo($permission->name)) checked @endif>
                        <label class="custom-control-label text-capitalize" for="{{ $permission->id }}">{{ $permission->title }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="col-lg-12 p-0 mt-4">
        <div class="form-group">
            <button type="submit" class="btn btn-md btn-primary" data-button="submit">Save</button>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).on('click', '.group-permissions', function() {
        if ($(this).is(':checked')) {
            $(this).parent().siblings().find('.custom-control-input').prop('checked', true);
        } else {
            $(this).parent().siblings().find('.custom-control-input').prop('checked', false);
        }
        updateAssignAllCheckbox();
    });
    $(document).on('click', '.assign-all', function() {
        if ($(this).is(':checked')) {
            $('.custom-control-input').prop('checked', true);
        } else {
            $('.custom-control-input').prop('checked', false);
        }
    });

    $(document).on('click', '.permission-checkbox', function() {
        if (!$(this).is(':checked')) {
            $(this).parent().siblings().find('.group-permissions').prop('checked', false);
        } else {
            if (!($(this).parent().siblings().find('.permission-checkbox').is(':checked') === false)) {
                $(this).parent().siblings().find('.group-permissions').prop('checked', true);
            }
        }
        updateAssignAllCheckbox();
    });

    function updateAssignAllCheckbox() {
        $('.group-permissions').each(function() {
            var groupCheckbox = $(this);
            var groupContainer = groupCheckbox.closest('.col-lg-3');
            var permissionCheckboxes = groupContainer.find('.permission-checkbox');
            var allChecked = true;

            permissionCheckboxes.each(function() {
                if (!$(this).is(':checked')) {
                    allChecked = false;
                    return false;
                }
            });

            if (allChecked) {
                groupCheckbox.prop('checked', true);
            } else {
                groupCheckbox.prop('checked', false);
            }
        });

        var allPermissionCheckboxes = $('.permission-checkbox');
        var assignAllCheckbox = $('.assign-all');

        if (allPermissionCheckboxes.filter(':not(:checked)').length > 0) {
            assignAllCheckbox.prop('checked', false);
        } else {
            assignAllCheckbox.prop('checked', true);
        }
    }

    </script>
@endpush
