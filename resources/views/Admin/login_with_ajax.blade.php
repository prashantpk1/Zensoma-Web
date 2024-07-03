<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{  static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{  static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <title>Cuba - Premium Admin Template</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/sweetalert2.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{  static_asset('admin/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{  static_asset('admin/assets/css/responsive.css') }}') }}">
    <!-----  Toastr Css---->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-----  Toastr Css Ends---->
  </head>
  <body>
    <!-- login page start-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 p-0">
          <div class="login-card login-dark">
            <div>
              <div><a class="logo text-center" href="#"><img class="img-fluid for-light" src="{{  static_asset('admin/assets/images/logo/logo.png') }}" alt="looginpage"><img class="img-fluid for-dark" src="{{  static_asset('admin/assets/images/logo/logo_dark.png') }}" alt="looginpage"></a></div>
              <div class="login-main">
                <form method="POST" action="{{ route('login') }}" class="theme-form">
                        @csrf
                  <h4>Login</h4>
                  <p>Enter your email & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Email</label>
                    <input class="form-control" type="email" placeholder="Email Address" name="email" id="email" @error('email') is-invalid @enderror>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                     <div class="form-input position-relative">
                      <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"  placeholder="Password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>

                  </div>
                  <div class="form-group mb-0">
                    <div class="text-end mt-3">
                      <input class="btn btn-primary btn-block w-100" type="submit" value="Login">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="{{  static_asset('admin/assets/js/jquery.min.js') }}"></script>
      <!-- Bootstrap js-->
      <script src="{{  static_asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
      <!-- feather icon js-->
      <script src="{{  static_asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script>
      <script src="{{  static_asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="{{  static_asset('admin/assets/js/config.js') }}"></script>
      <!-- Plugins JS start-->
      <script src="{{  static_asset('admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="{{  static_asset('admin/assets/js/script.js') }}"></script>


      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

      <script>
          toastr.options = {
              "closeButton": true,
              "progressBar": true
          }
          @if (Session::has('success'))
              toastr.success("{{ session('success') }}");
          @endif
          @if (Session::has('error'))
              toastr.error("{{ session('error') }}");
          @endif
          @if (Session::has('message'))
              toastr.success("{{ session('message') }}");
          @endif

          @if (Session::has('info'))
              toastr.info("{{ session('info') }}");
          @endif

          @if (Session::has('warning'))
              toastr.warning("{{ session('warning') }}");
          @endif
      </script>



    </div>
  </body>
</html>
