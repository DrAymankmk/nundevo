<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{ trans('site.mall_title') }}</title>
    <link href="{{ asset('media/logo/logo_header.png')}}" sizes="128x128" rel="icon" type="image/png" />
    <link href="{{ asset('media/logo/logo_header.png')}}" sizes="128x128" rel="shortcut icon" type="image/png" />
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    {{--    <link--}}
    {{--        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css"--}}
    {{--        rel="stylesheet">--}}
    <link
            href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/feather-icon.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/select2.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/timepicker.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/rating.css') }}">

    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/date-picker.css')}}">

    {{--    <!-- Plugins css start-->--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/datatables.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/prism.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/style.css')}}">

    <link id="color" rel="stylesheet" href="{{asset('/admin/css/light-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/admin/css/responsive.css')}}">

</head>

<body main-theme-layout="rtl">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="loader bg-white">
        <div class="whirly-loader"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">

    <!-- Page Header Start-->
    <div class="page-main-header">
        <div class="main-header-right row">
            <div class="main-header-left d-lg-none">
                <div class="logo-wrapper"><a href=""><img src="{{ asset('images/logo/logo.png')}}" alt=""></a></div>
            </div>
            <div class="mobile-sidebar d-block">
                <div class="media-body text-right switch-sm">
                    <label class="switch"><a><i id="sidebar-toggle"
                                                data-feather="align-left"></i></a></label>
                </div>
            </div>

            <div class="nav-right col p-0">
                <ul class="nav-menus">
                    <li>
                    </li>
                    <li><a class="text-dark" href="#" onclick="javascript:toggleFullScreen()"><i
                                    data-feather="maximize"></i></a></li>
                    <li><a href=""></a></li>
                    <li class="onhover-dropdown">
                        <div class="media align-items-center"><img
                                    class="align-self-center pull-right img-50 rounded-circle"
                                    src="{{ \Illuminate\Support\Facades\Auth::user()->image }}" alt="header-user">
                            <div class="dotted-animation"><span class="animate-circle"></span><span
                                        class="main-circle"></span></div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div p-20">
                            <li><a href="{{ route('profile') }}" style="font-size: 12px;"><i data-feather="user"></i> البروفايل</a></li>
                            <li><a href="{{ route('admin.logout') }}" style="font-size: 12px;"><i data-feather="log-out"></i> تسجيل الخروج</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
            </div>


        </div>
    </div>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <br>
        <!-- Page Sidebar Start-->
        <div class="page-sidebar">
            <br>
            <div class="main-header-left d-none d-lg-block">
                <div class="logo-wrapper"><a href="{{route('admin.dashboard')}}">
                        <img src="{{ asset('images/logo/header-logo.png')}}"
                             style="margin: 10px auto;display: table;width: 100%;" alt=""></a></div>
            </div>
            <div class="sidebar custom-scrollbar">
                <div class="sidebar-user text-center">
                    <div><img class="img-60 rounded-circle" src="{{ Auth::user()->image }}"
                              alt="#">
                        <div class="profile-edit"><a href="{{ route('profile') }}" target="_blank"><i
                                        data-feather="edit"></i></a></div>
                    </div>
                    <h6 class="mt-3 f-14">{{ Auth::user()->name }}</h6>
                    @if(Auth::user()->type == 1)
                        <p>مدير المشروع</p>
                    @else
                        <p>مشرف النظام</p>
                    @endif
                </div>
                <ul class="sidebar-menu">
                    @if (auth()->user()->hasPermissionTo('عرض الصفحة الرئيسية'))
                        <li><a class="sidebar-header" href="{{ route('admin.dashboard') }}"><i
                                        data-feather="home"></i><span>الصفحه الرئيسية</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض مشرف'))
                        <li><a class="sidebar-header" href="{{ route('supervisor') }}"><i
                                        data-feather="users"></i><span>المشرفيين</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض المعرض'))
                        <li><a class="sidebar-header" href="{{ route('admin-gallery') }}"><i
                                        data-feather="image"></i><span>معرض الصور والفيديوهات</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض اقسام'))
                        <li><a class="sidebar-header" href="{{ route('categories') }}"><i
                                        data-feather="eye"></i><span>الأقسام الرئيسية</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض قسم فرعى'))
                        <li><a class="sidebar-header" href="{{ route('cities') }}"><i
                                        data-feather="globe"></i><span>الأقسام الفرعية</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض مشروع'))
                        <li><a class="sidebar-header" href="{{ route('real-states') }}"><i
                                        data-feather="eye"></i><span>كل الوحدات</span></a>
                        </li>

                        <li><a class="sidebar-header" href="{{ route('Hot-deals') }}"><i
                                        data-feather="eye"></i><span>صفقات</span></a>
                        </li>

                        @foreach($categories as $category)
                            <li><a class="sidebar-header"
                                   href="{{ route('projects', $category->id) }}"><i
                                            data-feather="eye"></i><span>{{ $category->name_ar }}</span></a>
                            </li>
                        @endforeach

                        <li><a class="sidebar-header" href="{{ route('properties',1) }}"><i
                                        data-feather="eye"></i><span>خيارات متقدمة للوحدات</span></a>
                        </li>

                        <li><a class="sidebar-header" href="{{ route('properties',2) }}"><i
                                        data-feather="eye"></i><span>شكل الوحده</span></a>
                        </li>
                        <li><a class="sidebar-header" href="{{ route('properties',3) }}"><i
                                        data-feather="arrow-down-circle"></i><span>نوع الوحدات</span></a>
                        </li>
                        <li><a class="sidebar-header" href="{{ route('properties',4) }}"><i
                                        data-feather="arrow-down-circle"></i><span>تفاصيل اضافيه للوحدات</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('اضافة مشروع'))
                        <li><a class="sidebar-header" href="{{ route('add-project') }}"><i
                                        data-feather="plus"></i><span>اضف مشروع</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo('عرض اتصل بنا'))
                        <li><a class="sidebar-header" href="{{ route('project-contactUs',0) }}"><i
                                        data-feather="eye"></i><span> اتصل بنا خاص بالوحدات</span></a>
                        </li>

                        <li><a class="sidebar-header"
                               href="{{ route('contact') }}"><i
                                        data-feather="map"></i><span>اتصل بنا</span></a>
                        </li>
                        <li><a class="sidebar-header"
                               href="{{ route('career-message') }}"><i
                                        data-feather="message-square"></i><span>رسائل طلب وظيفة</span></a>
                        </li>
                        <li><a class="sidebar-header"
                               href="{{ route('contactUs') }}"><i
                                        data-feather="message-square"></i><span>رسائل التواصل معنا</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض سلايدر'))
                        <li><a class="sidebar-header" href="{{ route('sliders') }}"><i
                                        data-feather="eye"></i><span>سلايدر الصفحة الرئيسية</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض وسائل التواصل'))

                        <li><a class="sidebar-header"
                               href="{{ route('SocialMedia') }}"><i
                                        data-feather="arrow-down"></i><span>وسائل التواصل الاجتماعى</span></a>
                        </li>
                    @endif
                    @if (auth()->user()->hasPermissionTo('عرض اشتراك العملاء'))

                        <li><a class="sidebar-header"
                               href="{{ route('subscribe') }}"><i
                                        data-feather="arrow-down"></i><span>الاشتراك  فى الاشعارات</span></a>
                        </li>

                        <li><a class="sidebar-header"
                               href="{{ route('notifications') }}"><i
                                        data-feather="send"></i><span>اشعارات بريدية</span></a>
                        </li>

                    @endif
                    @if (auth()->user()->hasPermissionTo('عرض التقارير'))
                        <li><a class="sidebar-header"
                               href="{{ route('reports') }}">
                                <i data-feather="search"></i>
                                <span>التقارير</span></a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('عرض الاعدادات'))

                        <li><a class="sidebar-header" href=""><i
                                        data-feather="settings"></i><span>الاعدادت</span>
                                <i class="fa fa-angle-right pull-right"></i></a>
                            <ul class="sidebar-submenu">
                                <li><a class="sidebar-header"
                                       href="{{ route('chooseUs') }}"><i
                                                data-feather="chrome"></i><span>اختيارك لنا</span></a>
                                </li>

                                <li><a class="sidebar-header"
                                       href="{{ route('partners') }}"><i
                                                data-feather="users"></i><span>شركاؤنا</span></a>
                                </li>

                                <li><a class="sidebar-header"
                                       href="{{ route('aboutUs') }}"><i
                                                data-feather="target"></i><span>من نحن</span></a>
                                </li>

                                {{--<li><a class="sidebar-header"--}}
                                       {{--href="{{ route('ourTeam',1) }}"><i--}}
                                                {{--data-feather="users"></i><span>فريقنا</span></a>--}}
                                {{--</li>--}}
                                <li><a class="sidebar-header"
                                       href="{{ route('ourTeam',2) }}"><i
                                                data-feather="check"></i><span>اراء العملاء</span></a>
                                </li>

                                <li><a class="sidebar-header"
                                       href="{{ route('terms') }}"><i
                                                data-feather="check"></i><span>الشروط والاحكام</span></a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{--<li><a class="sidebar-header" href="{{ route('notifications') }}"><i--}}
                    {{--data-feather="send"></i><span>الاشعارات</span></a>--}}
                    {{--</li>--}}

                </ul>
            </div>
        </div>


        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <div class="page-header-left">
                                <h3>{{!empty($data['report_title']) ? $data['report_title'] : ""}}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('reports')}}"><i
                                                    data-feather="home"> </i> البحث </a></li>
                                    <li class="breadcrumb-item active">نتيجه
                                        البحث {{ count($data['projects'])  }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">

                            @if( count($data['projects']) > 0)
                                <div class="card-body">
                                    <div class="dt-ext table-responsive">
                                        <table class="display" id="export-button">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('admin.image')}}</th>
                                                <th>الاسم</th>
                                                <th>تم البيع</th>
                                                <th>كود العقار</th>
                                                <th>قسم العقار</th>
                                                <th>ترتيب العقار</th>
                                                <th>السعر</th>
                                                <th>القسم الفرعى</th>
                                                <th>نوع العقار</th>
                                                <th>حالة العقار</th>
                                                <th>{{trans('admin.action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data['projects']  as $index=>$project)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><img class="img-100 rounded-circle" src="{{ $project->image }}"
                                                             alt="#" data-original-title="" title=""></td>
                                                    <td>{{ $project->name_ar}}</td>
                                                    @if($project->confirm == 1)
                                                        <td>لا</td>
                                                    @else
                                                        <td>نعم</td>
                                                    @endif
                                                    <td>{{ $project->real_code }}</td>
                                                    <td>{{ $project->project_city->category->name_ar }}</td>
                                                    <td>{{ $project->real_arrange }}</td>
                                                    <td>{{ round($project->price,2) }}</td>
                                                    <td>{{ $project->project_city->city->name_ar }}</td>
                                                    <td>{{ $project->property->name_ar }}</td>
                                                    <td>
                                                        @if (auth()->user()->hasPermissionTo('تعديل مشروع'))
                                                            <div class="media-body text-left icon-state">
                                                                <label class="switch">
                                                                    <input type="checkbox"
                                                                           {{ $project->status == 1 ? 'checked' : '' }}
                                                                           onchange="change_status_project({{ $project->id }},{{ $project->status }})"><span
                                                                            class="switch-state bg-primary"></span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('project-details', $project->id) }}"
                                                           class="btn btn-info btn-sm"
                                                           title="تفاصيل العقار"><i
                                                                    class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('project-contactUs', $project->id) }}"
                                                           class="btn btn-info btn-sm"
                                                           title="رسائل اتصل بنا خاصة بالعقار"><i
                                                                    class="fa fa-eye"></i>
                                                        </a>

                                                        @if (auth()->user()->hasPermissionTo('تعديل مشروع'))
                                                            <a href="{{ route('project-edit', $project->id) }}"
                                                               class="btn btn-info btn-sm"
                                                               title="تعديل العقار"><i
                                                                        class="fa fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->hasPermissionTo('حذف مشروع'))
                                                            <form action="{{ route('delete-project', $project->id) }}"
                                                                  method="post" style="display: inline-block">
                                                                {{ csrf_field() }}
                                                                {{ method_field('delete') }}
                                                                <button type="submit"
                                                                        class="btn btn-danger delete btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <h4 class="text-center" style="color: #ff0000"> {{ trans('admin.no_data') }} </h4>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Page Sidebar Ends-->

        <!-- Right sidebar Ends-->


        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">جميع حقوق النشر محفوظه</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right mb-0"><img src="{{ asset('images/logo/grand.png')}}" style="width:100px;">
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    $('#basic-3').dataTable({
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "ابحث:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            }
        }
    });
</script>

<!-- latest jquery-->
<script src="{{asset('/admin/js/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('/admin/js/bootstrap/popper.min.js')}}"></script>
<script src="{{asset('/admin/js/bootstrap/bootstrap.js')}}"></script>
<!-- feather icon js-->
<script src="{{asset('/admin/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{asset('/admin/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('/admin/js/sidebar-menu.js')}}"></script>
<script src="{{asset('/admin/js/config.js')}}"></script>

<script src="{{asset('admin/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/jszip.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('admin/js/datatable/datatable-extension/custom.js')}}"></script>

<script src="{{asset('admin/js/chat-menu.js')}}"></script>

<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('admin/js/script.js')}}"></script>


<script type="text/javascript">

    $(document).ready(function () {
        $('#all_orders').DataTable({
            responsive: true,
            ordering: true,
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;

                    var select = $('<select><option value="">اختر</option></select>')
                        .appendTo($("#filters").find("th").eq(column.index()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column.data().unique().sort().each(function (d, j) {
                        $(select).append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
<!-- Plugin used-->

