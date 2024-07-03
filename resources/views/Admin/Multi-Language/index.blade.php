@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Keys and Contents for App</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createmultilanguagemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display multi-language-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Key</th>
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



    <div class="modal fade" id="createmultilanguagemodel" tabindex="-1" role="dialog"
        aria-labelledby="createmultilanguagemodel" aria-hidden="true">
        @include('Admin.Multi-Language.create')
    </div>


    <!-- edit customer model --->
    <div class="modal fade" id="editmultilanguagemodel" tabindex="-1" role="dialog"
        aria-labelledby="editmultilanguagemodel" aria-hidden="true">
    </div>
    <!-- edit customer model end --->

    <!-- show customer model --->
    <div class="modal fade" id="showcustomermodel" tabindex="-1" role="dialog" aria-labelledby="showcustomermodel"
        aria-hidden="true">
    </div>
    <!-- show customer model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.multi-language-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('multi-language.index') }}",
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
                        data: 'key',
                        name: 'key'
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
            $("#multi-language-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                // var refresh = "yes";
                // create_record(frm, table, refresh);

                var formData = new FormData(frm);
                    var url = $(this).attr('action');
                    jQuery('.btn-custom').addClass('disabled');
                    jQuery('.icon').removeClass('d-none');
                    $.ajax({

                            url: url,
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                                success: function(response) {
                                show_toster(response.success)
                                table.draw();
                                $("#is_close").click();
                                frm.reset();
                                jQuery('.btn-custom').removeClass('disabled');
                                jQuery('.icon').addClass('d-none');
                                location.reload();
                            },
                            error: function(xhr) {
                                var errors = xhr.responseJSON;
                                $.each(errors.errors, function(key, value) {
                                    var ele = "#" + key;
                                    toastr.error(value);
                                });
                                jQuery('.btn-custom').removeClass('disabled');
                                jQuery('.icon').addClass('d-none');
                            },

                    });            });
            //add multi-language submit end





            //delete record
            $(".multi-language-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });



            //status-change
            $(".multi-language-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });


            //get customer data for edit page
            $(".multi-language-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editmultilanguagemodel').html(response);
                        $('#editmultilanguagemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get customermodel data for edit page end


            //edit multi language
            $(document).on('submit', '#multi-language-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editmultilanguagemodel";
                edit_record(frm, url, formData, model_name, table);
            });
            //edit multi language end

        });
    </script>
@endsection
