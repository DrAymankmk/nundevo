<div id="delete_sup_{{$supervisor->id}}" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-3">
            <form action="{{route('destroy-Account',$supervisor->id)}}" method="POST">
                @csrf
                @method('delete')
                <img src="/assets/img/sent.png" alt="" width="60" class="mb-3">
                <h5>@lang('admin.Are you sure you want to delete this?')</h5>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('admin.close')</button>
                    <button type="submit" class="btn btn-danger">@lang('admin.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
