<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    @include('Admin.layouts.partials.head')
</head>
<!--end::Head-->


<?php $url = Request::route()->getName(); ?>


<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <!--begin::Header wrapper-->
        <div class="page-header">
            @include('Admin.layouts.partials.navbar')
        </div>
        <!--end::Header wrapper-->
        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" sidebar-layout="stroke-svg">
                <!--begin::Header sidebar-->
                @include('SubAdmin.layouts.partials.sidebar')
                <!--begin::Header sidebar-->
            </div>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Main content -->
                @yield('content')
                <!-- /.content -->
            </div>
            <!-- footer start-->
            <footer class="footer">
                <!--begin::Header wrapper-->
                @include('Admin.layouts.partials.footer')
                <!--end::Header wrapper-->
            </footer>
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
    <!-- Plugins JS start-->
    <script src="{{ static_asset('admin/assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/sidebar-pin.js') }}"></script>
    {{-- <script src="{{ static_asset('admin/assets/js/clock.js') }}"></script> --}}
    <script src="{{ static_asset('admin/assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/slick/slick.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/header-slick.js') }}"></script>

    <script src="{{ static_asset('admin/assets/js/height-equal.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/animation/wow/wow.min.js') }}"></script>

    <!-- Plugins JS Ends-->

    <!---  datatable --->
    <script src="{{ static_asset('admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <!---  datatable end  ---->

    <!--- select --->
    <script src="{{ static_asset('admin/assets/js/select2.min.js') }}"></script>
    <!-- select --->
    <!-- Theme js-->
    <script src="{{ static_asset('admin/assets/js/script.js') }}"></script>
    {{-- <script src="{{ static_asset('admin/assets/js/theme-customizer/customizer.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!---  ck editor -->
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <!---- ck editor -->

    <!--- calendar ---->
    <script src="{{ static_asset('admin/assets/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/calendar/fullcalendar-custom.js') }}"></script>
    <!--- calendar ---->


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

        function show_toster(message)
        {
            (function ($) {
                    "use strict";
                    var notify = $.notify(
                        '<i class="fa fa-bell-o"></i>' + message,
                        {
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

                    setTimeout(function () {
                        notify.update(
                        "message",
                        '<i class="fa fa-bell-o"></i>' + message
                        );
                    }, 1000);
                    })(jQuery);
        }



        function change_status()
        {
            e.preventDefault();
                var confirm = Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: $(this).data('url'),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status == '1') {
                                    // toastr.success(response.success)
                                    show_toster(response.success)
                                    table.draw();

                                }
                            }
                        });
                    }
                });
        }

    </script>

  <!-- script -->
  @yield('script')
  <!-- /.script -->


</body>

</html>
