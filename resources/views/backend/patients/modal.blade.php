@php
    $isEdit = isset($patient) ? true : false;
    $url = $isEdit ? route('patients.update', $patient->id) : route('patients.store');
@endphp
<form action="{{$url}}" method="post" data-form="ajax-form" data-modal="#ajax_model" data-datatable="#patients_datatable">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="patient_id">Patient ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="patient_id" value="{{ $isEdit ? $patient->patient_id : $patientId }}" readonly>
        </div>
        <div class="form-group col-lg-6">
            <label for="first_name">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $isEdit ? $patient->first_name : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="last_name">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $isEdit ? $patient->last_name : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ $isEdit ? $patient->date_of_birth : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="gender">Gender <span class="text-danger">*</span></label>
            <select class="form-control form-select" name="gender" id="gender">
                <option value="" selected disabled> -- Select Gender --</option>
                <option value="male" @if ($isEdit && $patient->gender == 'male') selected @endif>Male</option>
                <option value="female" @if ($isEdit && $patient->gender == 'female') selected @endif>Female</option>
                <option value="other" @if ($isEdit && $patient->gender == 'other') selected @endif>Other</option>
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="age">Age <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="age" id="age" value="{{ $isEdit ? $patient->age : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="blood_group"> Blood Group <span class="text-danger">*</span></label>
            <select class="form-control form-select" name="blood_group" id="blood_group" required>
                <option value="" selected disabled> -- Select Blood Group --</option>
                @foreach (config('bloodgroups') as $bloodGroup)
                    <option value="{{ $bloodGroup }}" @if ($isEdit && $patient->blood_group == $bloodGroup) selected @endif>{{ $bloodGroup }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
            <select class="form-control form-select" name="marital_status" id="marital_status">
                <option value="" selected disabled> -- Select Marital Status --</option>
                <option value="married" @if ($isEdit && $patient->marital_status == 'married') selected @endif>Married</option>
                <option value="unmarried" @if ($isEdit && $patient->marital_status == 'unmarried') selected @endif>Un Married</option>
            </select>
        </div>
        <div class="form-group col-lg-6">
            <label for="address">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="address" id="address" value="{{ $isEdit ? $patient->address : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="contact_number">Contact Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="contact_number" id="contact_number" value="{{ $isEdit ? $patient->contact_number : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="primary_care_physician">Primary Care Physician <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="primary_care_physician" id="primary_care_physician" value="{{ $isEdit ? $patient->primary_care_physician : '' }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label for="patient_diagnose">Patient Diagnose <span class="text-danger">*</span></label>
            <textarea class="form-control" name="patient_diagnose" id="patient_diagnose" required>{{ $isEdit ? $patient->patient_diagnose : '' }}</textarea>
        </div>
        <div class="form-group col-lg-6">
            <label for="past_illness">Past Illness</label>
            <textarea class="form-control" name="past_illness" id="past_illness">{{ $isEdit ? $patient->past_illness : '' }}</textarea>
        </div>
        <div class="form-group col-lg-6">
            <label for="past_surgeries">Past Surgeries</label>
            <textarea class="form-control" name="past_surgeries" id="past_surgeries">{{ $isEdit ? $patient->past_surgeries : '' }}</textarea>
        </div>
        <div class="form-group col-lg-6">
            <label for="allergic">Allergic</label>
            <textarea class="form-control" name="allergic" id="allergic">{{ $isEdit ? $patient->allergic : '' }}</textarea>
        </div>
        <div class="form-group col-lg-6 d-none">
            <label for="status"> Status <span class="text-danger">*</span></label>
            <select class="form-control form-select" name="status" id="status" required>
                <option value="active" selected>Active</option>
                {{-- <option value="active" {{ $isEdit && $patient->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $isEdit && $patient->status === 'inactive' ? 'selected' : '' }}>inactive</option> --}}
            </select>
        </div>
    </div>

    <div class="col-lg-12 px-0">
        <button type="submit" class="btn btn-primary" data-button="submit">Submit</button>
    </div>
</form>
