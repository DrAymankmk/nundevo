<div class="modal fade" id="add_suervisor" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('create-supervisor')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">@lang('admin.add_supervisor')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @include('main_admin.supervisor.form', ['cities' => $cities])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('admin.close')</button>
                    <button type="submit" class="btn btn-primary">@lang('admin.add')</button>
                </div>
            </form>
        </div>
    </div>
</div>
