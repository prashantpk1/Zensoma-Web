@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Search Word List</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a title="Add Language" class="btn btn-sm btn-primary"
                                href="{{ route('language.create') }}"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New </a></li> --}}


                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createlanguagemodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display word-data" id="">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Word</th>
                                        <th>Search Valumes</th>
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




@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.word-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                language: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('word.index') }}",
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
                        data: 'word',
                        name: 'word'
                    },
                    {
                        data: 'volumes',
                        name: 'volumes'
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
            $(".word-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url,table);
            });



        });
    </script>
@endsection
