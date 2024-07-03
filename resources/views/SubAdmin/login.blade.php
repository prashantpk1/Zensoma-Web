<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<?php
$url = URL::to('/sub_admin_dashboard');
?>
<!--begin::Head-->

<head>
    @include('admin.layouts.partials.head')
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
                            <form method="POST" action="{{ route('login') }}" class="theme-form" id="login-frm">
                                @csrf
                                <h4>Login</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="email" placeholder="Email Address"
                                        name="email" id="email" @error('email') is-invalid @enderror>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <input class="btn btn-primary btn-block w-100" type="submit" value="Login"
                                            id="loginsubmit">
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

            function show_toster(message) {
                (function($) {
                    "use strict";
                    var notify = $.notify(
                        '<i class="fa fa-bell-o"></i><strong>Loading..</strong>Login Succusfully......', {
                            type: "theme",
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: true,
                            timer: 300,
                            animate: {
                                enter: "animated fadeInDown",
                                exit: "animated fadeOutUp",
                            },
                        }
                    );

                    setTimeout(function() {
                        notify.update(
                            "message",
                            '<i class="fa fa-bell-o"></i><strong>Loading..</strong>Login Succusfully......'
                        );
                    }, 1000);
                })(jQuery);
            }
        </script>

        <script type="text/javascript">
            $(document).ready(function() {

                //add login
                $("#login-frm").submit(function(event) {

                    event.preventDefault();

                    var frm = this;

                    var method = "POST";

                    var url = $(this).attr('action');



                    var formData = new FormData(frm);

                    $.ajax({

                        url: url,

                        type: method,

                        data: formData,

                        processData: false,

                        contentType: false,

                        success: function(response) {

                            show_toster(response.success)

                            var dashboard = "{{ $url }}";

                            window.location.href = dashboard;



                        },

                        error: function(xhr) {
                            // $('#send').button('reset');
                            var errors = xhr.responseJSON;
                            $.each(errors.errors, function(key, value) {
                                console.log(key);
                                var ele = "#" + key;
                                // $(ele).addClass('unique_error is-invalid');
                                toastr.error(value);
                            });
                        },


                    });



                });
                //add login end


            });
        </script>




    </div>
</body>

</html>
