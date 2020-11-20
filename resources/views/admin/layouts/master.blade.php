<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>@yield('title')</title>
  <!-- loader-->
  <!-- <link href="{{asset('/css/pace.min.css')}}" rel="stylesheet"/> -->
  <!-- <script src="{{asset('/js/pace.min.js')}}"></script> -->
  <!--favicon-->
  <link rel="icon" href="{{asset('/images/favicon.ico')}}" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="{{asset('/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
  <!-- simplebar CSS-->
  <link href="{{asset('/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{asset('/css/animate.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{asset('/css/icons.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="{{asset('/css/sidebar-menu.css')}}" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="{{asset('/css/app-style.css')}}" rel="stylesheet"/>
 
 
  @yield('stylesheet')
  <style type="text/css">
    .icon-arrow-down::before {
       font-size: 6px;
     }
     .container-fluid { 
  padding-right: 0px;
  padding-left: 0px;  
  }
  .content-wrapper {
   padding-left: 1px;
    padding-right: 1px;
    padding-bottom: 20px;
    padding-top: 61px;
  }
  .row.row-group>div {
    border-right: 1px solid rgba(255, 255, 255, 0.12);
     border-bottom: 1px solid rgba(255, 255, 255, 0.12);
}
.modal-content {
  background: #041e3a !important;
}
  </style>
</head>

<body class="bg-theme bg-theme4">
 
<!-- Start wrapper-->@include('admin.layouts.sidebar')<!--End sidebar-wrapper-->

<!--Start topbar header-->@include('admin.layouts.tonav')<!--End topbar header-->

<div class="clearfix"></div>
  
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->

  @yield('content')

      <!--End Dashboard Content-->
    
  <!--start overlay-->
      <div class="overlay toggle-menu"></div>
    <!--end overlay-->
    
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
  
  <!--Start footer-->@include('admin.layouts.footer')<!--End footer-->
  
  <!--start color switcher-->
   <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">

      <p class="mb-0">Gaussion Texture</p>
      <hr>
      
      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>

      <p class="mb-0">Gradient Background</p>
      <hr>
      
      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
    <li id="theme13"></li>
        <li id="theme14"></li>
        <li id="theme15"></li>
      </ul>
      
     </div>
   </div>
  <!--end color switcher-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  @yield('script')

  <script src="{{asset('/js/jquery.min.js')}}"></script>

  <script src="{{asset('/js/popper.min.js')}}"></script>
  <script src="{{asset('/js/bootstrap.min.js')}}"></script>
  
 <!-- simplebar js -->
  <script src="{{asset('/plugins/simplebar/js/simplebar.js')}}"></script>
  <!-- sidebar-menu js -->
  <script src="{{asset('/js/sidebar-menu.js')}}"></script>
  <!-- loader scripts -->
  <script src="{{asset('/js/jquery.loading-indicator.js')}}"></script>
  <!-- Custom scripts -->
  <script src="{{asset('/js/app-script.js')}}"></script>
  <!-- Chart js -->
  
  <script src="{{asset('/plugins/Chart.js/Chart.min.js')}}"></script>
 
  <!-- Index js -->
  <script src="{{asset('/js/index.js')}}"></script>

  
</body>
</html>
