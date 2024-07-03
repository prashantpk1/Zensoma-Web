@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>CMS Pages</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcmsmodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li> --}}

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
                            <table class="display cms-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Last Update At</th>
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



    <!-- create cms model --->
    <div class="modal fade" id="createcmsmodel" tabindex="-1" role="dialog" aria-labelledby="createcmsmodel"
        aria-hidden="true">
        @include('Admin.Cms-Pages.create')
    </div>
    <!-- create cms model end --->


    <!-- edit cms model --->
    <div class="modal fade" id="editcmsmodel" tabindex="-1" role="dialog" aria-labelledby="editcmsmodel"
        aria-hidden="true">
    </div>
    <!-- edit cms model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.cms-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('cms.index') }}",
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
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
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
            $(".cms-data").on('click', '.destroy-data', function(e) {
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
            });




            //add cms
            $("#cms-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm,table);
            });
            //add cms end



             //get cms data for edit page
             $(".cms-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editcmsmodel').html(response);
                        $('#editcmsmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get cms data for edit page end



            ///edit cms
            $(document).on('submit', '#cms-edit-frm', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editcmsmodel";
                edit_record(frm, url, formData, model_name, table);
            });
            //edit cms end

        });
    </script>
@endsection
