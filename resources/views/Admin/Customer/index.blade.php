@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Customer List</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcustomermodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li>--}}


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
                            <table class="display customer-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Referral Code</th>
                                        <th>Date Of Joing</th>
                                        <th>Is Approved</th>
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



    <!-- edit customer model --->
    <div class="modal fade" id="editcustomermodel" tabindex="-1" role="dialog" aria-labelledby="editcustomermodel"
        aria-hidden="true">
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
            var table = $('.customer-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                customer: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('customer.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_details',
                        name: 'user_details'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'referral_code',
                        name: 'referral_code'
                    },
                    {
                        data: 'joing_date',
                        name: 'joing_date'
                    },
                    {
                        data: 'is_approved',
                        name: 'is_approved'
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
            $(".customer-data").on('click', '.destroy-data', function(e) {
                        e.preventDefault();
                        var url = $(this).data('url');
                        delete_record(url,table);
            });


              //status-change
              $(".customer-data").on('click', '.status-change', function(e) {
                        e.preventDefault();
                        var url = $(this).data('url');
                        change_status(url,table);
            });


            //get customer data for edit page
            $(".customer-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editcustomermodel').html(response);
                        $('#editcustomermodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get customermodel data for edit page end


             //get customer data for edit page
             $(".customer-data").on('click', '.show-data', function(e) {
                 $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#showcustomermodel').html(response);
                        $('#showcustomermodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get customermodel data for edit page end







            //edit editcustomermodel
            $(document).on('submit', '#customer-edit-form', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editcustomermodel";
                edit_record(frm, url, formData, model_name, table);
            });
             //edit customer end

        });
    </script>
@endsection
