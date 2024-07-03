@extends('Admin.layouts.app')
@section('content')
<style>

</style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Tranactions</h4>
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
                                        <th>Customer Detail</th>
                                        <th>Payment Mode</th>
                                        <th>Transaction Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Tranaction At</th>
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
                ajax: "{{ route('transaction.index') }}",
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
                        data: 'user_detail',
                        name: 'user_detail',
                    },
                    {
                        data: 'payment_mode',
                        name: 'payment_mode'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
