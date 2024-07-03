@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Gamification-Config</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                             <!-- <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createconfigmodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button> -->
                            </li>
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
                            <table class="display config-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Config Name</th>
                                        <th>Config Key</th>
                                        <th>Config Value</th>
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



    <!-- create config model --->
    <div class="modal fade" id="createconfigmodel" tabindex="-1" role="dialog" aria-labelledby="createconfigmodel"
        aria-hidden="true">
        @include('Admin.Gamification-Config.create')
    </div>
    <!-- create config model end --->


    <!-- edit config model --->
    <div class="modal fade" id="editconfigmodel" tabindex="-1" role="dialog" aria-labelledby="editconfigmodel"
        aria-hidden="true">
    </div>
    <!-- edit config model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.config-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                config: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('gamification-config.index') }}",
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
                        data: 'config_name',
                        name: 'config_name'
                    },
                    {
                        data: 'config_key',
                        name: 'config_key'
                    },
                    {
                        data: 'config_value',
                        name: 'config_value'
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
            $(".config-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".config-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add config submit
            $("#config-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add config submit end


            //get config data for edit page
            $(".config-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editconfigmodel').html(response);
                        $('#editconfigmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get config data for edit page end


            //edit config
            $(document).on('submit', '#gamification-config-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editconfigmodel";
                edit_record(frm, url, formData, model_name, table);
           });

        });



    </script>
@endsection
