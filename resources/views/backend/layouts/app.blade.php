<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-bs-theme="light" class="sf-js-enabled" data-topbar="success" data-layout-style="default" data-layout-width="fluid"
    data-sidebar-image="none" data-layout-position="fixed">

<head>

    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Laravel Dashboard Template" name="description">
    <meta content="PixCafeNetword" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.0/css/all.min.css" />
    <!-- Layout config Js -->
    <script src="{{ asset('backend/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">


    {{-- Libraries --}}
    <link href="{{ asset('backend/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/libs/filepond/filepond.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/libs/filepond/filepond-plugin-image-preview.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/assets/libs/filepond/filepond-plugin-file-poster.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/toastify-js/src/toastify.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.grey.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.darkgrey.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.inverted.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/icofont/icofont.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- custom Css-->
    <link href="{{ asset('backend/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/custom.css?ts=' . time()) }}" rel="stylesheet" type="text/css">
    {{-- jQuey --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.8.2/dist/alpine.min.js" defer></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}


    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>


    <x-tinymce-config />

    @stack('css')
</head>

<body>

    @include('backend.layouts.notice')

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('backend.layouts.sidebar')
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        @include('backend.layouts.header')
        <div class="wrapper"></div>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@yield('page-title')</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">@yield('page-title')</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-white">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ config('starter.COPYRIGHT') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by {{ config('starter.DEVELOPED') }}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>


    {{-- Libraries --}}
    <script src="{{ asset('backend/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/sortablejs/Sortable.min.js') }}"></script>
    <script src='{{ asset('backend/assets/libs/toastify-js/src/toastify.js') }}'></script>
    <!-- apexcharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


    {{-- initiated --}}
    <script src="{{ asset('backend/assets/js/pages/nestable.init.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/sweetalerts.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond-plugin-image-resize.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('backend/assets/libs/filepond/filepond-plugin-image-exif-orientation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond-plugin-file-validate-type.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond-plugin-file-encode.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond-plugin-image-preview.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/filepond/filepond-plugin-file-poster.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('backend/assets/libs/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/assets/libs/fonticonpicker/jquery.fonticonpicker.min.js') }}">
    </script>

    <!-- mailbox init -->
    {{-- <script src="{{ asset('backend/assets/js/pages/mailbox.init.js') }}"></script> --}}
    {{-- Widget init --}}
    {{-- <script src="{{ asset('backend/assets/js/pages/widgets.init.js') }}"></script> --}}

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>


    @stack('js')

</body>


</html>
