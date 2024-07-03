<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google font-->
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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ static_asset('admin/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/responsive.css') }}">
  </head>
  <body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- error-404 start-->
      <div class="error-wrapper">
        <div class="container"><img class="img-100" src="{{ static_asset('admin/assets/images/other-images/sad.png') }}" alt="">
          <div class="col-md-8 offset-md-2">
            <p class="sub-content">You  Don't have permission to access this page.</p>
          </div>
          <div>
          <?php $user =  Auth::user(); ?>
          @if($user)
            <a class="btn btn-danger-gradien btn-lg" href="javascript(0)" onclick="goBack()">Go Back</a>
         @else
                <a class="btn btn-danger-gradien btn-lg" href="{{  route('login')}}">Login</a>
         @endif
        </div>
          </div>
      </div>
      <!-- error-404 end      -->
    </div>
    <!-- latest jquery-->
    <script src="{{ static_asset('admin/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ static_asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="{{ static_asset('admin/assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ static_asset('admin/assets/js/script.js') }}"></script>



<script>
function goBack() {
    // This will navigate the user back to the previous page
    window.history.back();
}
</script>

  </body>
</html>
