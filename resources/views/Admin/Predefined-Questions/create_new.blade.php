@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Add Question</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('question.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ route('question.index') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Predefined Questions</li>
                        <li class="breadcrumb-item active">Add Question</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body add-post">
                        <form class="row" method="post"
                            action="{{ route('question.store') }}" enctype="multipart/form-data" id="question-frm">
                            @csrf
                            <?php $language = get_language(); ?>
                            <div class="row col-sm-12 g-3">


                                @foreach ($language as $key => $lang)
                                    @php
                                        $text_error = 'Question.' . $lang['code'] . '.Question';
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">{{ $lang['language'] }} Question</span>
                                        </label>
                                        <input type="text" name="question[{{ $lang['code'] }}][question]" id="key"
                                            class="form-control" placeholder="Enter Question"
                                            @error('key') is-invalid @enderror>
                                    </div>
                                @endforeach

                                <div class="sm-3 col-md-12">
                                    <label class="form-label" for="coupon_code">Option Type</label>
                                    <select name="option_type" id="option_type" aria-label="Select a Option Type"
                                        data-placeholder="Select a Option Type..." class="form-select form-control">
                                        <option value="checkbox">Check Box</option>
                                        <option value="range">Range</option>
                                        <option value="radio">Radio</option>
                                    </select>
                                </div>



                                <div class="row g-3" id="radio">
                                    @foreach ($language as $key => $lang)
                                        @php
                                            $text_error = 'option.' . $lang['code'] . '.option';
                                        @endphp
                                        <div class="col-md-6">
                                            <label class="col-form-label">
                                                <span class="required">{{ $lang['language'] }} Option</span>
                                            </label>
                                            <input type="text" name="option[{{ $lang['code'] }}][0]" id="key"
                                                class="form-control" placeholder="Enter Option"
                                                @error('key') is-invalid @enderror>
                                        </div>
                                    @endforeach


                                    <div class="col-10">
                                    </div>
                                    <div class="col-2">
                                        <ol class="breadcrumb">
                                                <button type="button" class="btn btn-sm btn-primary" id="add_option"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></button>
                                        </ol>
                                    </div>

                                </div>


                                <div class="col-sm-12" id="add_option_div">
                                </div>


                                <div class="row g-3 d-none" id="range">
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">Start Value</span>
                                        </label>
                                        <input type="number" name="start_number" id="option" class="form-control"
                                            placeholder="Enter Range">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">End Value</span>
                                        </label>
                                        <input type="number" name="end_number" id="option" class="form-control"
                                            placeholder="Enter Range">
                                    </div>
                                </div>


                            </div>
                        </form>
                        <div class="btn-showcase text-end">
                                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

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

               //add question submit
               $("#question-frm").submit(function(event) {
                event.preventDefault();
                var frm = this;
                create_record(frm, table);
            });
            //add question submit end


        });
    </script>
@endsection
