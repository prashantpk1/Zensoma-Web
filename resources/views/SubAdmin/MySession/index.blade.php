@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>MY Session Management</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcontentmodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li> --}}

                        <li class="breadcrumb-item"><a class="btn btn-sm btn-primary" type="button"  href="{{ route('my-session.create')}}"><i class="fa fa-plus" aria-hidden="true"></i>Add New</a></li>


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
                            <table class="display content-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Content Type</th>
                                        <th>Duration</th>
                                        <th>Creater Name</th>
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


    {{-- <div class="modal fade" id="createcontentmodel" tabindex="-1" role="dialog" aria-labelledby="createcontentmodel"
        aria-hidden="true">
        @include('SubAdmin.MySession.create')
    </div>


    <!-- edit content model --->
    <div class="modal fade" id="editcontentmodel" tabindex="-1" role="dialog" aria-labelledby="editcontentmodel"
        aria-hidden="true">
    </div>
    <!-- edit content model end ---> --}}

    <!-- show content model --->
    <div class="modal fade" id="showcontentmodel" tabindex="-1" role="dialog" aria-labelledby="showcontentmodel"
        aria-hidden="true">
    </div>
    <!-- show content model end --->
@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.content-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('my-session.index') }}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: true,
                    // },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'content_type',
                        name: 'content_type'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'creater_name',
                        name: 'creater_name'
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



            //add multi language Submit
            $("#content-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add content submit end


            //delete record
            $(".content-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });

            //status-change
            $(".content-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });





            //get content data for edit page
            $(".content-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editcontentmodel').html(response);
                        $('#editcontentmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get contentmodel data for edit page end


            //edit editcontentmodel
            $(document).on('submit', '#content-frm-edit', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editcontentmodel";
                edit_record(frm, url, formData, model_name, table);
            });
            //edit content end

            // $('.custom_select2').select2({
            //     dropdownParent: $('#createcontentmodel')
            // });

            $('.js-example-basic-multiple').select2({
                dropdownParent: $('#createcontentmodel')
            });



            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });


        });
    </script>
@endsection
