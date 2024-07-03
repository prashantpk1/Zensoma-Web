@extends('Admin.layouts.app')
@section('content')
    <?php $language = get_language();
    ?>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Predefined Question</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createquestionmodel"><i class="fa fa-plus" aria-hidden="true"></i>
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
                            <table class="display question-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Question</th>
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



    <!-- create question model --->
    <div class="modal fade" id="createquestionmodel" tabindex="-1" role="dialog" aria-labelledby="createquestionmodel"
        aria-hidden="true">
        @include('Admin.Predefined-Questions.create')
    </div>
    <!-- create question model end --->


    <!-- edit question model --->
    <div class="modal fade" id="editquestionmodel" tabindex="-1" role="dialog" aria-labelledby="editquestionmodel"
        aria-hidden="true">
    </div>
    <!-- edit question model end --->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.question-data').DataTable({
                processing: true,
                serverSide: true,
                // dom: 'lfrtip',
                question: {
                    processing: '<i></i><span class="text-primary spinner-border"></span> '
                },
                ajax: "{{ route('question.index') }}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: true,
                    // },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'question',
                        name: 'question'
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
            $(".question-data").on('click', '.destroy-data', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                delete_record(url, table);
            });



            //status-change
            $(".question-data").on('click', '.status-change', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                change_status(url, table);
            });




            //add question submit
            $("#question-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                var formData = new FormData(frm);
                    var url = $(this).attr('action');
                    jQuery('.btn-custom').addClass('disabled');
                    jQuery('.icon').removeClass('d-none');
                    $.ajax({

                            url: url,
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                                success: function(response) {
                                show_toster(response.success)
                                table.draw();
                                $("#is_close").click();
                                frm.reset();
                                jQuery('.btn-custom').removeClass('disabled');
                                jQuery('.icon').addClass('d-none');
                                location.reload();
                            },
                            error: function(xhr) {
                                var errors = xhr.responseJSON;
                                $.each(errors.errors, function(key, value) {
                                    var ele = "#" + key;
                                    toastr.error(value);
                                });
                                jQuery('.btn-custom').removeClass('disabled');
                                jQuery('.icon').addClass('d-none');
                            },

                    });
            });
            //add question submit end


            //get question data for edit page
            $(".question-data").on('click', '.edit-data', function(e) {
                $.ajax({
                    method: "GET",
                    url: $(this).data('url'),
                    success: function(response) {
                        $('#editquestionmodel').html(response);
                        $('#editquestionmodel').modal('show');
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });
            //get question data for edit page end


            //edit question
            $(document).on('submit', '#question-edit-frm', function(e) {
                e.preventDefault();
                var frm = this;
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                formData.append("_method", 'PUT');
                var model_name = "#editquestionmodel";

                jQuery('.btn-custom').addClass('disabled');
                    jQuery('.icon').removeClass('d-none');
                    $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $(model_name).modal('hide');
                        show_toster(response.success)
                        table.draw();
                        frm.reset();
                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');
                        location.reload();
                    },
                    error: function(xhr) {
                        // $('#send').button('reset');
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            toastr.error(value);
                            jQuery('.btn-custom').removeClass('disabled');
                            jQuery('.icon').addClass('d-none');
                        });
                    },
                });
                // edit_record(frm, url, formData, model_name, table);
            });
            //edit question end

            var i = '1';
            $("#add_option").click(function(e) {
                var html = '';
                html += `<div class="row" id="remove_option">`;
                @foreach ($language as $key => $lang)
                    html += `<div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">` + "{{ $lang['language'] }}" + ` Option</span>
                        </label>
                            <input type="text" name="option[` + "{{ $lang['code'] }}" + `][` + i + `]" id="key" class="form-control" placeholder="Enter Option" @error('key') is-invalid @enderror required>
                    </div>`;
                @endforeach
                html +=
                    `<div class="col-sm-6">
                       <br>
                        <button type="button" class="btn btn-sm btn-primary remove-option"  onclick="return confirm('Are you sure you want to delete this item')"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>`

                $("#add_option_div").append(html);
                i++;
            });
            $(document).on('click', '.remove-option', function() {
                $(this).closest('div#remove_option').remove();
            });



            $('#option_type').on('change', function() {
                if (this.value == "range") {
                    $("#range").removeClass("d-none");
                    $("#radio").addClass("d-none");
                } else {
                    $("#radio").removeClass("d-none");
                    $("#range").addClass("d-none");
                }
            });


        });

        $(document).on('change', '#option_type1', function(e) {
            if (this.value == "range") {
                    $("#range-section").removeClass("d-none");
                    $("#section-option").addClass("d-none");
                } else {
                    $("#section-option").removeClass("d-none");
                    $("#range-section").addClass("d-none");
                }
        });
    </script>
@endsection
