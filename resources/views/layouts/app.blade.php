<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- تضمين Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* تحسينات لجعل الـ Sidebar يستجيب بشكل جيد على الأجهزة الصغيرة */
        @media (max-width: 768px) {
            .main-sidebar {
                width: 100%;
                position: absolute;
                z-index: 1050;
                display: none; /* إخفاء الشريط الجانبي بشكل افتراضي على الأجهزة الصغيرة */
            }
            .content-wrapper {
                margin-left: 0 !important;
            }
            .navbar-toggler {
                display: block; /* عرض زر التبديل على الأجهزة الصغيرة */
            }
        }

        /* تحسينات للقائمة العلوية */
        .navbar-toggler {
            display: none; /* إخفاء زر التبديل على الأجهزة الكبيرة */
        }
    </style>

    @php
        $name = \App\Models\Setting::where('key','name')->first()->value;
        $logo = \App\Models\Setting::where('key','logo')->first()->value;
    @endphp
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">

                <button type="button" class="btn text-danger" data-toggle="modal" data-target="#logout">
                    logout
                </button>
            </li>
        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <img src="{{$logo}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{$name}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link {{ Route::is('categories.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-layer-group"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('courses.index')}}" class="nav-link {{ (Route::is('courses.*') || Route::is('course-videos.*')) ? 'active' : ''}}">
                                <i class="nav-icon fa fa-book"></i>
                                <p>Courses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('students.index')}}" class="nav-link {{ Route::is('students.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>Students</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('orders.index')}}" class="nav-link {{ Route::is('orders.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('banners.index')}}" class="nav-link {{ Route::is('banners.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-images"></i>
                                <p>Banners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('payments.index')}}" class="nav-link {{ Route::is('payments.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-money-check-alt"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('finance.index')}}" class="nav-link {{ Route::is('finance.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-chart-line"></i>
                                <p>Finance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contacts.index')}}" class="nav-link {{ Route::is('contacts.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-share"></i>
                                <p>Social</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('partners.index')}}" class="nav-link {{ Route::is('partners.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-handshake"></i>
                                <p>Partners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('settings.index')}}" class="nav-link {{ Route::is('settings.*') ? 'active' : ''}}">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                    </ul>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="modal fade" id="logout">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-dark">
                    Are you sure you need to login out
                </div>
                <div class="modal-footer justify-content-between">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Yes, logout</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
            </div>
        </section>

        <section class="content">
            @yield('main-content')
        </section>
    </div>

    <footer class="main-footer">
        <!-- محتوى التذييل -->
    </footer>
</div>

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
@include('sweetalert::alert')

<script>
    $(document).ready(function () {
        if (typeof $.AdminLTE !== 'undefined') {
            $('[data-widget="pushmenu"]').on('click', function (e) {
                e.preventDefault();
                $('body').toggleClass('sidebar-open sidebar-collapse');
            });
        } else {
            console.error("AdminLTE لم يتم تحميله أو PushMenu غير موجود.");
        }
    });
</script>




</body>
</html>


