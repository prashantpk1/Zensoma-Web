<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
    content="">
<meta name="keywords"
    content="">
<meta name="author" content="redpark">
{{-- {{ static_asset('admin/assets/media/logos/favicon.jpeg') }} --}}
<?php $url = Request::route()->getName(); ?>


<link rel="icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
<title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/animate.css') }}">
    <!-- Plugins css Ends-->

    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/intltelinput.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/tagify.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ static_asset('admin/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/responsive.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-----  Toastr Css---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-----  Toastr Css Ends---->

@php
$urlarray = explode('.', $url);
$first = $urlarray[0] ?? null;
$second = $urlarray[1] ?? null;
$thread = $urlarray[2] ?? null;
@endphp
@if ($first == 'index' || $second == 'index' || $thread == 'index')
<!--  Datatable  Css --->
  <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/datatables.css') }}">
<!--   End Datatable Css --->
@endif

<!---  add ---->

<!--  Calendar  Css --->
<link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/calendar.css') }}">
<!--   End Calendar Css --->

<!--  flatpickr  Css --->
<link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/flatpickr/flatpickr.min.css') }}">
<!--  flatpickr  Css --->

<!---  add ---->


