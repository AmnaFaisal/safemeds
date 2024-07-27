<form action="{{ route('update-report-status', [$id, 'rejected']) }}" method="post" data-form="ajax-form" data-modal="#ajax_model" data-refresh="true">
    @csrf
    <div class="row">
        <div class="form-group col-lg-12">
            <label for="comment">Comment: <span class="text-danger">*</span></label>
            <textarea type="text" class="form-control" name="comment" id="comment"></textarea>
        </div>
    </div>
    <div class="col-lg-12 px-0">
        <button type="submit" class="btn btn-primary" data-button="submit">Reject</button>
    </div>
</form>