@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Languages</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a title="Add Language" class="btn btn-sm btn-primary"
                                href="{{ route('language.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New </a></li> --}}


                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createlanguagemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display language-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Language</th>
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



    <!-- create language model --->
    <div class="modal fade" id="createlanguagemodel" tabindex="-1" role="dialog" aria-labelledby="createlanguagemodel"
        aria-hidden="true">
        @include('Admin.Language.create')
    </div>
    <!-- create language model end --->


    <!-- edit language model --->
    <div class="modal fade" id="editlanguagemodel" tabindex="-1" role="dialog" aria-labelledby="editlanguagemodel"
        aria-hidden="true">
    </div>
    <!-- edit language model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.language-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('language.index') }}",
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'language',
                        name: 'language'
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
            $(".language-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });


            //status-change
            $(".language-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add language submit
            $("#language-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add language submit end


            //get language data for edit page
            $(".language-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editlanguagemodel').html(response);
                        $('#editlanguagemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get language data for edit page end


            //edit language
            $(document).on('submit', '#language-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editlanguagemodel";
                edit_record(frm, url, formData, model_name, table);
            });
            //edit language end

        });
    </script>
@endsection
