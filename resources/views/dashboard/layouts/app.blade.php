<!DOCTYPE html>
<html class="loading semi-dark-layout" data-layout="semi-dark-layout" data-textdirection="rtl"  lang="{{app()->getLocale()}}">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>@lang('aqarcom')</title>
    <link rel="apple-touch-icon" href="{{asset('dashboard_files/')}}/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('dashboard_files/')}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files/app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files/app-assets/vendors/css/extensions/toastr.min.css')}}">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if(app()->getLocale() == "ar")
        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/vendors/css/vendors-rtl.min.css">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/colors.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/components.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/themes/bordered-layout.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/themes/semi-dark-layout.css">

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/plugins/forms/form-validation.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/pages/page-auth.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css-rtl/custom-rtl.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/style-rtl.css">
        <!-- END: Custom CSS-->
    @else
        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/vendors/css/vendors.min.css">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/themes/bordered-layout.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/themes/semi-dark-layout.css">

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/plugins/forms/form-validation.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/pages/page-auth.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/custom-rtl.css">
        <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/css/style.css">

        <!-- END: Custom CSS-->
    @endif
    <link rel="stylesheet" type="text/css" href="{{asset('dashboard_files')}}/app-assets/DataTables-1.13.1/css/jquery.dataTables.css"/>

    {{--noty--}}
    <link rel="stylesheet" href="{{ asset('website/css/noty.css') }}">
    <script src="{{ asset('website/javascript/noty.min.js') }}"></script>


    <style>
        body{
            font-family: 'Calibri' , sans-serif !important;
        }

        .search-bar{
            height: 60px;
            display: flex;
            align-items: center;
        }
        .search-form{
            display: flex;
            align-items: center;
        }

        .main-menu.menu-dark .navigation > li > ul li:not(.has-sub) {
            margin: 5px 30px !important;
        }

        label {
            color: #5e5873 !important;
            font-size: 1.3rem !important;
        }

        .card-title{
            font-size: 1.7rem !important;
            font-weight: bold !important;
        }

        .custom-switch{
            margin-left: 14px;
        }
        html[lang='ar'] .custom-switch{
            margin-right: 14px;
        }
        html[lang='ar'] th{
            text-align: right !important;
        }
    </style>
    @yield('styles')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">



@include('dashboard.partials.navbar')
@include('dashboard.partials.sidebar')


@yield('content')


<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->

@include('partials.errorAlert')
@include('partials.successAlert')
<!-- BEGIN: Vendor JS-->

<script src="{{asset('dashboard_files/app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('dashboard_files/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('dashboard_files/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- END: Page Vendor JS-->
<script type="text/javascript" src="{{asset('dashboard_files')}}/app-assets/DataTables-1.13.1/js/jquery.dataTables.js"></script>

<!-- BEGIN: Theme JS-->
<script src="{{asset('dashboard_files/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('dashboard_files/app-assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{asset('dashboard_files/app-assets/js/scripts/pages/dashboard_files`_files-ecommerce.js')}}"></script>

<script src="{{ asset('dashboard_files/app-assets/js/ckeditor/ckeditor.js') }}"></script>
<script>

    $(document).ready(function () {
        $('#datatable-table').DataTable({
            "language": {
                "url": "{{asset('dashboard_files')}}/app-assets/DataTables-1.13.1/translations/{{app()->getLocale()}}.json"
            },
            "aaSorting": [],
        });
    });
    $(document).ready(function () {
        $('#datatable-table2').DataTable({
            "language": {
                "url": "{{asset('dashboard_files')}}/app-assets/DataTables-1.13.1/translations/{{app()->getLocale()}}.json"
            },
            "aaSorting": [],
        });
    });
</script>
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })



    $('.change-status').on('click' , function (){

    });

    CKEDITOR.config.language =  "{{ app()->getLocale() }}";

</script>
@stack('scripts')
</body>
<!-- END: Body-->
</html>
