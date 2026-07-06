@extends('includes_admin.mainlayout')
@section('content')

    <!-- Right sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            <h3>الاشعارات</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                                data-feather="home"> </i> الرئيسية </a></li>
                                <li class="breadcrumb-item active">الاشعارات</li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body btn-showcase">
                            <!-- Simple demo-->
                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                    data-target="#notification" data-whatever="@category">ارسال رساله
                            </button>

                            <div class="modal fade" id="notification" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">ارسال رساله</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="needs-validation" novalidate=""
                                                  action="{{route('send-messages')}}"
                                                  method="POST" enctype="multipart/form-data">
                                                {{ method_field('POST') }}
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label for="validationCustom05"
                                                           class="page-header-left">العملاء</label>
                                                    <select name="user_id"
                                                            class="form-control"
                                                            required>
                                                        @if(count($users) == 0)
                                                            <option value="">لا يوجد عملاء</option>
                                                        @elseif(count($users) >= 2)
                                                            <option value="">اختر</option>
                                                            <option value="all">كل العملاء</option>
                                                            @foreach($users as $user)
                                                                <option
                                                                        value="{{ $user->id }}">{{ $user->email }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">اختر</option>
                                                            @foreach($users as $user)
                                                                <option
                                                                        value="{{ $user->id }}">{{ $user->email }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback">{{ $errors->first('user_id') }}</div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="validationCustom05"
                                                           class="col-form-label page-header-left"> عنوان
                                                        الرساله</label>
                                                    <input class="form-control" name="title"
                                                           type="text"
                                                           placeholder=" ادخل عنوان الرساله"
                                                           required="">
                                                    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="validationCustom05"
                                                           class="col-form-label page-header-left"> محتوى
                                                        الرساله</label>
                                                    <textarea class="form-control" name="message"
                                                              type="text"
                                                              placeholder="ادخل  محتوى الرساله"
                                                              required=""></textarea>
                                                    <div
                                                            class="invalid-feedback">{{ $errors->first('message') }}</div>
                                                </div>

                                                {{--<div class="form-group">--}}
                                                    {{--<label for="validationCustom05"--}}
                                                           {{--class="page-header-left">صوره</label>--}}
                                                    {{--<div class="custom-file">--}}
                                                        {{--<input class="custom-file-input" type="file"--}}
                                                               {{--name="image">--}}
                                                        {{--<label class="custom-file-label" for="validatedCustomFile">اختر--}}
                                                            {{--صوره</label>--}}
                                                        {{--<div--}}
                                                                {{--class="invalid-feedback">{{ $errors->first('image') }}</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                <span class="text-danger page-header-left"
                                                      style="color: red;">{{$errors->first('message')}}</span>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">ارسال</button>
                                                    <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">اغلاق
                                                    </button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        @if( count($messages) > 0)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display dataTable" id="basic-1">
                                        <thead>
                                        <tr>
                                            <th> المسلسل</th>
                                            <th>صوره</th>
                                            <th>اسم المرسل اليه</th>
                                            <th>عنوان الرساله</th>
                                            <th>محتوى الرساله</th>
                                            <th>الاجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($messages as $index=>$message)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><img
                                                            src="{{ !empty($message->image) ? $message->image : 'لا يوجد صوره' }}"
                                                            style="width: 50px" alt=""></td>
                                                <td>{{ !empty($message->user_id) ? $message->user->email : 'كل العملاء' }}</td>
                                                <td>{{ $message->title }}</td>
                                                <td>{{ $message->message }}</td>
                                                <td>
                                                    <form action="{{ route('delete-notification', $message->id) }}"
                                                          method="post" style="display: inline-block">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        <button type="submit"
                                                                class="btn btn-danger delete btn-sm">
                                                            <i
                                                                    class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <h6 class="text-center" style="color: #ff0000"> لا توجد رسائل مرسله </h6>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
