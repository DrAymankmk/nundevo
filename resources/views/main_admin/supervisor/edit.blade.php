<div class="modal fade" id="edit_sup_{{$supervisor->id}}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('update-supervisor',$supervisor->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title">@lang('admin.edit_supervisor')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('main_admin.supervisor.form', ['supervisor' => $supervisor, 'cities' => $cities])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('admin.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
