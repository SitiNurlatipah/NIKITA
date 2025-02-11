<!DOCTYPE html>

<html class="loading semi-dark-layout" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
  <meta name="description" content="">
  <meta name="keywords" content="Mapping Competencies">
  <meta name="author" content="Rezki Ramadhan">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-mini.png')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('include.style')
  @stack('style')
  <style>
    /* .img-cover {
      background-image: url("assets/images/logo-mini.png");
      background-repeat: no-repeat; 
      background-position: 98% -5.8%; 
      background-size: 300px 240px;
    } */

    .content-wrapper {
      padding-top: 15px;
    }

    .modal .modal-dialog {
      margin-top: 10px;
    }

    .expandable-table tr td {
    padding: 10px;
    font-size: 13px;
    }

    .dataTables_wrapper .dataTable .btn i {
    font-size : 0.775rem;
    margin-right:0.0rem;
    }

    .btn.btn-icon {		   
    width: 37px;
    height: 37px;
    padding: 0;
    }

    .btn {
    border-radius: 14px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">

    @include('include.header')

    <div class="container-fluid page-body-wrapper">
      @include('include.sidebar')

      <!-- BEGIN: Content-->
      <div class="main-panel">
        <div class="content-wrapper img-cover">
          @yield('content')
        </div>
      </div>
      <!-- END: Content-->
    </div>
  </div>
  @include('include.script')
  @include('include.footer')
  @stack('script')
</body>

</html>
