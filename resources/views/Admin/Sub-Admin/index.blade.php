@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Sub Admin</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createsubadminmodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display subadmin-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sub Admin</th>
                                        {{-- <th>Role Name</th> --}}
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Referral Code</th>
                                        <th>Date Of Joing</th>
                                        <th>Is Approved</th>
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



    <!-- create subadmin model --->
    <div class="modal fade" id="createsubadminmodel" tabindex="-1" role="dialog" aria-labelledby="createsubadminmodel"
        aria-hidden="true">
        @include('Admin.Sub-Admin.create')
    </div>
    <!-- create subadmin model end --->


    <!-- edit subadmin model --->
    <div class="modal fade" id="editsubadminmodel" tabindex="-1" role="dialog" aria-labelledby="editsubadminmodel"
        aria-hidden="true">
    </div>
    <!-- edit subadmin model end --->

    <!-- show subadmin model --->
    <div class="modal fade" id="showsubadminmodel" tabindex="-1" role="dialog" aria-labelledby="showsubadminmodel"
        aria-hidden="true">
    </div>
    <!-- show subadmin model end --->


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.subadmin-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('subadmin.index') }}",
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
                        data: 'user_details',
                        name: 'user_details'
                    },
                    // {
                    //     data: 'role_name',
                    //     name: 'role_name'
                    // },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'referral_code',
                        name: 'referral_code'
                    },
                    {
                        data: 'joing_date',
                        name: 'joing_date'
                    },
                    {
                        data: 'is_approved',
                        name: 'is_approved'
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
            $(".subadmin-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });


            //status-change
            $(".subadmin-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });




            //get subadmin data for edit page
            $(".subadmin-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editsubadminmodel').html(response);
                        $('#editsubadminmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get subadminmodel data for edit page end


            //get subadmin data for edit page
            $(".subadmin-data").on('click', '.show-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#showsubadminmodel').html(response);
                        $('#showsubadminmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get subadminmodel data for edit page end


            //add subadmin
            $("#subadmin-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add subadmin end





            //edit editsubadminmodel
            $(document).on('submit', '#subadmin-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name =  "#editsubadminmodel";
                edit_record(frm,url,formData,model_name,table);
            });
            //edit subadmin end

        });

</script>
@endsection
