<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<?php
$url = URL::to('/update-password');
?>
<!--begin::Head-->

<head>
    @include('Admin.layouts.partials.head')
</head>
<!--end::Head-->

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div><a class="logo text-center" href="#"><img class="img-fluid for-light"
                                    src="{{ static_asset('admin/assets/images/logo/logo.png') }}" alt="looginpage"><img
                                    class="img-fluid for-dark"
                                    src="{{ static_asset('admin/assets/images/logo/logo_dark.png') }}"
                                    alt="looginpage"></a></div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('verify_otp_check') }}" class="theme-form" id="submit-frm">
                                @csrf
                                <h4>Verify Otp</h4>
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="form-group">
                                    <input class="form-control @error('otp') is-invalid @enderror" id="otp" type="otp" placeholder="Otp" aria-label="otp" name="otp" required>
                                    @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                  </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <input class="btn btn-primary btn-block w-100" type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- latest jquery-->
        <script src="{{ static_asset('admin/assets/js/jquery.min.js') }}"></script>
        <!-- Bootstrap js-->
        <script src="{{ static_asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <!-- feather icon js-->
        <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather.min.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
        <!-- scrollbar js-->
        <script src="{{ static_asset('admin/assets/js/scrollbar/simplebar.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/scrollbar/custom.js') }}"></script>
        <!-- Sidebar jquery-->
        <script src="{{ static_asset('admin/assets/js/config.js') }}"></script>
        <script src="{{ static_asset('admin/assets/js/notify/bootstrap-notify.min.js') }}"></script>

        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ static_asset('admin/assets/js/script.js') }}"></script>
        {{-- <script src="{{ static_asset('admin/assets/js/theme-customizer/customizer.js') }}"></script> --}}

        <script>
            new WOW().init();
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    </div>
</body>

</html>
