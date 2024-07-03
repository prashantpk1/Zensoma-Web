@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Badgies</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createbadgemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display badge-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Badges Name</th>
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



    <!-- create badge model --->
    <div class="modal fade" id="createbadgemodel" tabindex="-1" role="dialog" aria-labelledby="createbadgemodel"
        aria-hidden="true">
        @include('Admin.Badges.create')
    </div>
    <!-- create badge model end --->


    <!-- edit badge model --->
    <div class="modal fade" id="editbadgemodel" tabindex="-1" role="dialog" aria-labelledby="editbadgemodel"
        aria-hidden="true">
    </div>
    <!-- edit badge model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.badge-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('badge.index') }}",
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
                        data: 'badge_name',
                        name: 'badge_name'
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
            $(".badge-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url,table);
            });



            //status-change
            $(".badge-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url,table);
            });




            //add badge
            $("#badge-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add badge end



             //get badge data for edit page
             $(".badge-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editbadgemodel').html(response);
                        $('#editbadgemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get badge data for edit page end



            ///edit badge
            $(document).on('submit', '#badge-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name =  "#editbadgemodel";
                edit_record(frm,url,formData,model_name,table);
            });
            //edit badge end

        });
    </script>
@endsection
