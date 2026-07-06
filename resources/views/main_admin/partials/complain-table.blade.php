<div class="table-responsive">
    <table class="table border-0 custom-table comman-table datatable mb-0">
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('admin.image')</th>
            <th>@lang('admin.patient_name')</th>
            <th>@lang('admin.Id_number')</th>
            <th>@lang('admin.mobile_number')</th>
            <th>@lang('admin.date')</th>
            <th>@lang('admin.reply')</th>
            <th>@lang('admin.options')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($complains_box as $index=>$complain_box)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="profile-image"><a
                        href="{{ route('patient-analysis', $complain_box->user_id) }}"><img
                            width="28" height="28"
                            src="{{$complain_box->users->image ?? null}}"
                            class="rounded-circle m-r-5"
                            alt="">{{$complain_box->users->name ?? null}}
                    </a></td>
                <td>{{ $complain_box->users->name }}</td>
                <td>{{ $complain_box->users->ID_Number ?? null }}</td>
                <td>{{ $complain_box->users->phone  ?? null }}</td>
                <td>{{  $complain_box->created_at }}</td>
                <td>{{  $complain_box->reply ?? null }}</td>

                <td class="d-flex gap-2">
                    <a href="javascript:void(0)" class="add-table-invoice"
                       data-bs-toggle="modal" data-bs-target="#reply_{{$complain_box->id}}"
                       title="Edit"><i
                            class="fa fa-pen-to-square"></i></a>
                    <a href="javascript:void(0)" class="add-table-invoice danger"
                       data-bs-toggle="modal" data-bs-target="#delete_complain_{{$complain_box->id}}"
                       title="Delete"><i class="fa fa-trash-can"></i></a>

                    <!-- Delete Department Modal -->
                    <div id="delete_complain_{{$complain_box->id}}" class="modal fade delete-modal" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form class="needs-validation" novalidate=""
                                      action="{{route('delete-message',$complain_box->id) }}"
                                      method="POST">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="modal-body text-center">
                                        <img src="/assets/img/sent.png" alt="" width="50" height="46">
                                        <h3>@lang('admin.Are you sure you want to delete this?')</h3>
                                        <div class="m-t-20"><a href="#" class="btn btn-white" data-bs-dismiss="modal">@lang('admin.close')</a>
                                            <button type="submit" class="btn btn-danger">@lang('admin.delete')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Department Modal End -->

                    <!-- Add Department Modal -->
                    <div class="modal custom-modal modal-bg fade bank-details" id="reply_{{$complain_box->id}}" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header py-2 px-3">
                                    <div class="form-header text-start mb-0">
                                        <h4 class="mb-0">@lang('admin.reply_message')</h4>
                                    </div>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-start py-4 px-3">
                                    <form id="add_complain_form" action="{{ route('add-reply',$complain_box->id) }}"
                                          method="POST">
                                        @csrf
                                        <div class="bank-inner-details">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group local-forms">
                                                        <label>@lang('admin.name_ar') <span class="login-danger">*</span></label>
                                                        <input class="form-control" placeholder="@lang('admin.question')" name="question"
                                                               readonly value="{{$complain_box->complain}}">
                                                    </div>
                                                </div>


                                                <div class="col-12">
                                                    <div class="form-group local-forms mb-0">
                                                        <label>@lang('admin.reply_message') <span class="login-danger">*</span></label>
                                                        <textarea class="form-control" name="message" style="min-height: 90px;"
                                                                  placeholder="@lang('admin.enter_text_here')" required
                                                                  rows="3" cols="30">{{ $complain_box->message ?? null }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer p-3">

                                            <div class="bank-details-btn">
                                                <a href="javascript:void(0);" data-bs-dismiss="modal"
                                                   class="btn bank-cancel-btn me-2">{{ trans('admin.cancel') }}</a>
                                                <button class="btn bank-save-btn"
                                                        type="submit">
                                                    {{ trans('admin.save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Add Department Modal End -->
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
