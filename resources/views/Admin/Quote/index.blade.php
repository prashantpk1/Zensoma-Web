@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Quotes</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createquotemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display quote-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Text</th>
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



    <!-- create quote model --->
    <div class="modal fade" id="createquotemodel" tabindex="-1" role="dialog" aria-labelledby="createquotemodel"
        aria-hidden="true">
        @include('Admin.Quote.create')
    </div>
    <!-- create quote model end --->


    <!-- edit quote model --->
    <div class="modal fade" id="editquotemodel" tabindex="-1" role="dialog" aria-labelledby="editquotemodel"
        aria-hidden="true">
    </div>
    <!-- edit quote model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.quote-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('quote.index') }}",
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
                        data: 'text',
                        name: 'text'
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
            $(".quote-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url,table);
            });



            //status-change
            $(".quote-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url,table);
            });




            //add quote
            $("#quote-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add quote end



             //get quote data for edit page
             $(".quote-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editquotemodel').html(response);
                        $('#editquotemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get quote data for edit page end



            ///edit quote
            $(document).on('submit', '#quote-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name =  "#editquotemodel";
                edit_record(frm,url,formData,model_name,table);
            });
            //edit quote end

        });
    </script>
@endsection
