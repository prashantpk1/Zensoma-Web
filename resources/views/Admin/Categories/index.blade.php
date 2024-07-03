@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Categories</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a title="Add Category" class="btn btn-sm btn-primary"
                        href="{{ route('category.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>
                        Add New </a></li> --}}

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcategorymodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display category-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Categories</th>
                                        <th>Categories Type</th>
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



    <!-- create category model --->
    <div class="modal fade" id="createcategorymodel" tabindex="-1" role="dialog" aria-labelledby="createcategorymodel"
        aria-hidden="true">
        @include('Admin.Categories.create')
    </div>
    <!-- create category model end --->


    <!-- edit category model --->
    <div class="modal fade" id="editcategorymodel" tabindex="-1" role="dialog" aria-labelledby="editcategorymodel"
        aria-hidden="true">
    </div>
    <!-- edit category model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.category-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('category.index') }}",
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
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'categories_type',
                        name: 'categories_type'
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
            $(".category-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });



            //status-change
            $(".category-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });


            //add category
            $("#category-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm,table);
            });
            //add category end



            //get category data for edit page
            $(".category-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editcategorymodel').html(response);
                        $('#editcategorymodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get category data for edit page end



            ///edit category
            $(document).on('submit', '#category-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editcategorymodel";
                edit_record(frm, url, formData, model_name, table);
            });
            //edit category end

        });
</script>
@endsection
