@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Customized-Notifications</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createnotificationmodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display notification-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Notification Type</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>



    <!-- create notification model --->
    <div class="modal fade" id="createnotificationmodel" tabindex="-1" role="dialog"
        aria-labelledby="createnotificationmodel" aria-hidden="true">
        @include('Admin.Customized-Notifications.create')
    </div>
    <!-- create notification model end --->


    <!-- edit notification model --->
    <div class="modal fade" id="editnotificationmodel" tabindex="-1" role="dialog" aria-labelledby="editnotificationmodel"
        aria-hidden="true">
    </div>
    <!-- edit notification model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.notification-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('notification.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    // {
                    //     data: 'id',
                    //     name: 'id'
                    // },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'notification_type',
                        name: 'notification_type'
                    },
                    {
                        data: 'user_type',
                        name: 'user_type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            //delete record
            $(".notification-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });




            //add notification
            $("#notification-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add notification end



            //get notification data for edit page
            $(".notification-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editnotificationmodel').html(response);
                        $('#editnotificationmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get notification data for edit page end

            // $('#notification_type').on('change', function() {
            //     if(this.value == "push_notification")
            //     {
            //         $("#content").removeClass("ckeditor");
            //     }
            //     else{
            //         $("#content").addClass("ckeditor");
            //     }
            // });



        });
    </script>
@endsection
