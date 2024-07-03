@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Category Type</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createtypemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display type-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
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



    <!-- create type model --->
    <div class="modal fade" id="createtypemodel" tabindex="-1" role="dialog" aria-labelledby="createtypemodel"
        aria-hidden="true">
        @include('Admin.Category-Type.create')
    </div>
    <!-- create type model end --->


    <!-- edit type model --->
    <div class="modal fade" id="edittypemodel" tabindex="-1" role="dialog" aria-labelledby="edittypemodel"
        aria-hidden="true">
    </div>
    <!-- edit type model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.type-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                type: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('category-type.index') }}",
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
                        data: 'type_name',
                        name: 'type_name'
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
            $(".type-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);

            });

            //status-change
            $(".type-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });



            //add type submit
            $("#category-type-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add type submit end


            //get type data for edit page
            $(".type-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#edittypemodel').html(response);
                        $('#edittypemodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get type data for edit page end


            //edit type
            $(document).on('submit', '#category-type-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#edittypemodel";
                edit_record(frm, url, formData, model_name, table);
           });



           $('#main_category').on('change', function() {
                var category_id = $('#main_category').val();
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('sub.category.list') }}",
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    $('.categoryData').empty();
                        jQuery.each(response, function(index, item) {
                        $('.categoryData').append(' <option value='+ item['id'] + ' >'+ item['category_name_en'] +'</option>  ')
                    });
                }
                });
            });


            $('.js-example-basic-multiple').select2({
                dropdownParent: $('#createtypemodel')
            });



            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });


        });

               document.getElementById("#closeButton").addEventListener("click", function() {
                alert("helo");
                var form = document.getElementById("category-type-frm");
                var inputs = form.getElementsByTagName("input");
                var textareas = form.getElementsByTagName("textarea");

                // Loop through all input elements and clear their values
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].value = "";
                }

                // Loop through all textarea elements and clear their values
                for (var i = 0; i < textareas.length; i++) {
                    textareas[i].value = "";
                }
            });


            function close_or_clear_refresh()
        {
            $('#myModal input[type="email"]').val(''); // Clear text inputs
            $('#myModal input[type="text"]').val(''); // Clear text inputs
            $('#myModal input[type="file"]').val(''); // Clear text inputs
            $('.custom_select2').val([]);
            location.reload();
        }

    </script>
@endsection
