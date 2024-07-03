@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Resources</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"  data-bs-target="#blogadd"><i class="fa fa-plus" aria-hidden="true"></i> Add
                                New</button></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display blog-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Resource Image</th>
                                        <th>Resource Title </th>
                                        <th>Create At</th>
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


    <!----  check new model ---->
    <div class="modal fade modal-bookmark" id="blogadd" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        @include('Admin.Blog.create')
    </div>
    <!-----  end check nem model --->


     <!-- edit blog model --->
        <div class="modal fade" id="editblogmodel" tabindex="-1" role="dialog" aria-labelledby="editblogmodel"
        aria-hidden="true">
            </div>
    <!-- edit blog model end --->

     <!-- show blog model --->
        <div class="modal fade" id="showblogmodel" tabindex="-1" role="dialog" aria-labelledby="showblogmodel"
        aria-hidden="true">
        </div>
    <!-- show blog model end --->

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.blog-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('blog.index') }}",
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
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'en_title',
                        name: 'en_title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
            $(".blog-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });



              //status-change
              $(".blog-data").on('click', '.status-change', function(e) {
                e.preventDefault();
               var url = $(this).data('url');
                  change_status(url,table);
              });




            //add blog submit
            $("#blog-frm").submit(function(event) {
               event.preventDefault();
                var frm = this;
                // create_record(frm,table);
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

                });

            });
            //add blog submit end



              //get blog data for edit page
              $(".blog-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editblogmodel').html(response);
                        $('#editblogmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get blog data for edit page end


             //get blog data for show page
             $(".blog-data").on('click', '.show-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#showblogmodel').html(response);
                        $('#showblogmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get blog data for show page end


            $(document).on('submit', '#blog-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editblogmodel";

                // edit_record(frm, url, formData, model_name, table);

                jQuery('.btn-custom').addClass('disabled');
                    jQuery('.icon').removeClass('d-none');
                    $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $(model_name).modal('hide');
                        show_toster(response.success)
                        table.draw();
                        frm.reset();
                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');
                        location.reload();
                    },
                    error: function(xhr) {
                        // $('#send').button('reset');
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            toastr.error(value);
                            jQuery('.btn-custom').removeClass('disabled');
                            jQuery('.icon').addClass('d-none');
                        });
                    },
                });

            });


            $('.my-custome-class').on('click', function() {
                var $this = $(this);
                    $this.button('loading');
                        setTimeout(function() {
                        $this.button('reset');
                    }, 8000);
                    });



        });
    </script>
@endsection
