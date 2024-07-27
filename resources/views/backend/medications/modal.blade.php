@php
    $url = route('medications.store');
@endphp
<form action="{{ $url }}" method="post" data-form="ajax-form" data-modal="#ajax_model"
    data-datatable="#medications_datatable">
    @csrf
    <div class="row">
        <div class="form-group col-lg-6">
            <label for="first_name">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="">
        </div>
        <div class="form-group col-lg-6">
            <label for="last_name">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="">
        </div>

        <div class="form-group col-lg-6">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="email" value="">
        </div>
        <div class="form-group col-lg-6">
            <label for="phone">Phone</label>
            <input type="number" class="form-control" name="phone" id="phone" value="">
        </div>
        <div class="form-group col-lg-6">
            <label for="status"> Status <span class="text-danger">*</span></label>
            <select class="form-control select2 form-select form-select-modal" name="status" id="status" required>
                <option value="active">Active</option>
                <option value="inactive">inactive</option>
            </select>
        </div>

        <div class="col-lg-12 px-0">
            <button type="submit" class="btn btn-primary" data-button="submit">Submit</button>
        </div>
</form>
