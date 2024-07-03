@extends('SubAdmin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>My Booking List</h4>
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
                            <table class="display my-booking-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Detail</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
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


        <!-- show booking model --->
        <div class="modal fade" id="showbookingmodel" tabindex="-1" role="dialog" aria-labelledby="showbookingmodel"
        aria-hidden="true">
        </div>
    <!-- show booking model end --->






@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.my-booking-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('my-booking.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        // orderable: false,
                        // searchable: true,
                    },
                    // {
                    //     data: 'id',
                    //     name: 'id'
                    // },
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });












        });
    </script>
@endsection
