@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Private Session List & Individual Detail</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

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
                            <table class="display booking-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sub Admin Detail</th>
                                        <th>Customer Detail</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <!-- <th>Action</th>  -->
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


        <!-- show booking model --->
        <div class="modal fade" id="showbookingmodel" tabindex="-1" role="dialog" aria-labelledby="showbookingmodel"
        aria-hidden="true">
        </div>
    <!-- show booking model end --->






@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.booking-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('booking.index') }}",
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
                        data: 'tharapist_detail',
                        name: 'tharapist_detail'
                    },
                    {
                        data: 'user_detail',
                        name: 'user_detail'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });



             //get booking data for show page
             $(".booking-data").on('click', '.show-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#showbookingmodel').html(response);
                        $('#showbookingmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get booking data for show page end









        });
    </script>
@endsection
