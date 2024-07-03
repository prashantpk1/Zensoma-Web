@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Buddy Network</h4>
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
                            <table class="display buddy-network-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Details</th>
                                        {{-- <th>User Referral Code</th> --}}
                                        <th>Buddy Referral</th>
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


      <!-- show buddy-network model --->
      <div class="modal fade" id="showbuddynetworkmodel" tabindex="-1" role="dialog" aria-labelledby="showbuddynetworkmodel"
      aria-hidden="true">
  </div>
     <!-- show buddy-network model end --->


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.buddy-network-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('buddy-network.index') }}",
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
                        data: 'user_details',
                        name: 'user_details'
                    },
                    // {
                    //     data: 'referral_code',
                    //     name: 'referral_code'
                    // },
                    {
                        data: 'number_of_refer',
                        name: 'number_of_refer'
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
            $(".buddy-network-data").on('click', '.destroy-data', function(e) {
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



              //get customer data for edit page
              $(".buddy-network-data").on('click', '.show-data', function(e) {
                 $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#showbuddynetworkmodel').html(response);
                        $('#showbuddynetworkmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get buddy-networkmodel data for edit page end






        });
    </script>
@endsection
