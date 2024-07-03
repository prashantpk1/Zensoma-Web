@extends('Admin.layouts.app')
@section('content')
<style>

</style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Subscriptions</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createsubscriptionmodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display subscription-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subscription Name</th>
                                        <th>Duration</th>
                                        <th>Amount</th>
                                        <th>Featured</th>
                                        <th>Subscription Type</th>
                                        <th>Created At</th>
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



    <!-- create subscription model --->
    <div class="modal fade" id="createsubscriptionmodel" tabindex="-1" role="dialog"
        aria-labelledby="createsubscriptionmodel" aria-hidden="true">
        @include('Admin.Subscription.create')
    </div>
    <!-- create subscription model end --->


    <!-- edit subscription model --->
    <div class="modal fade" id="editsubscriptionmodel" tabindex="-1" role="dialog" aria-labelledby="editsubscriptionmodel"
        aria-hidden="true">

    </div>
    <!-- edit subscription model end --->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.subscription-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('subscription.index') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'featured',
                        name: 'featured'
                    },
                    {
                        data: 'subscription_type',
                        name: 'subscription_type'
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
            $(".subscription-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });


            //status-change
            $(".subscription-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });






            //add subscription
            $("#subscription-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add subscription end



            //get subscription data for edit page
            $(".subscription-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editsubscriptionmodel').html(response);
                        $('#editsubscriptionmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get subscription data for edit page end



            ///edit subscription
            $(document).on('submit', '#subscription-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name =  "#editsubscriptionmodel";
                edit_record(frm,url,formData,model_name,table);
            });
            //edit subscription end



            $('#subscription_type').on('change', function() {
                if (this.value == "categories_wise") {
                    $("#category").removeClass("d-none");
                } else {
                    $("#category").addClass("d-none");
                }
            });





            //edit subscription end


            // $(".subscription-data").on('click', '.subscription_type', function(e) {
            //    alert("0");
            // });




        });


        $(document).on('change', '#subscription_type', function(e) {
            if (this.value == "categories_wise") {
                $("#category1").removeClass("d-none");
            } else {
                $("#category1").addClass("d-none");
            }
        });


        $('.custom_select2').select2({
            dropdownParent: $('#createsubscriptionmodel')
        });
    </script>
@endsection
