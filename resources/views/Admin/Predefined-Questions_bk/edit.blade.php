<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Predefined Question</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">
            <form class="form-bookmark needs-validation" method="post"
                action="{{ route('question.update', $data->id) }}" enctype="multipart/form-data" id="question-edit-frm">
                @csrf
                @method('put')
                <?php $language = get_language(); ?>
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row g-3">


                            <input type="hidden" name="option_type" id="option_type" class="form-control"
                                            placeholder="Enter Range" value="{{ $data['option_type']}}">

                            @foreach ($language as $key => $lang)
                                @php


                                    $array1 = json_decode($data['descriptions'], true);


                                @endphp

                                <div class="col-md-6">
                                    <label class="col-form-label">
                                        <span class="required">{{ $lang['language'] }} Question Description <span class="text-danger">*</span></span>
                                    </label>
                                    <textarea type="text" name="description[{{ $lang['code'] }}][description]" id="key"
                                        class="form-control"
                                        @error('key') is-invalid @enderror>@if (!empty($array1[$lang['code']]['description'])) {{ $array1[$lang['code']]['description'] }} @endif</textarea>
                                </div>




                            @endforeach

                            @foreach ($language as $key => $lang)
                            @php
                                $array = json_decode($data['question'], true);
                            @endphp

                            <div class="col-md-6">
                                <label class="col-form-label">
                                    <span class="required">{{ $lang['language'] }} Question <span class="text-danger">*</span></span>
                                </label>
                                <input type="text" name="question[{{ $lang['code'] }}][question]" id="key"
                                    class="form-control" placeholder="Enter Question"
                                    @error('key') is-invalid @enderror
                                    value="@if (!empty($array[$lang['code']]['question'])) {{ $array[$lang['code']]['question'] }} @endif">
                            </div>

                        @endforeach


                            @php
                                $total_option = 1;
                                $i = 0;
                                $number = $data->option->max('option_order') + 1 ?? 1;
                            @endphp
                            @if ($data->option_type == 'range')
                                <?php
                                $numberArray = explode('-', $data->options);
                                ?>

                                <div class="row" id="range">
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">Start Value</span>
                                        </label>
                                        <input type="number" name="start_number" id="option" class="form-control"
                                            placeholder="Enter Range" value="{{ $numberArray[0] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">End Value</span>
                                        </label>
                                        <input type="number" name="end_number" id="option" class="form-control"
                                            placeholder="Enter Range" value="{{ $numberArray[1] }}">
                                    </div>
                                </div>
                            @else
                                <?php  if($data->option != null) { ?>


                                <?php  foreach($data->option as $key=>$option)
                                            { ?>
                                <div class="col-md-6">
                                    <label class="col-form-label">
                                        <span class="required">{{ $option['language'] }}
                                            Option <span class="text-danger">*</span></span>
                                    </label>
                                    <input type="text"
                                        name="option[{{ $option['language'] }}][{{ $option['option_order'] }}]"
                                        id="key" class="form-control" placeholder="Enter Option"
                                        value="{{ $option->option }}">
                                </div>
                                <?php } ?>

                                <?php } ?>


                                <div class="col-10">

                                </div>
                                <div class="col-2">
                                    <ol class="breadcrumb">

                                        <button type="button" class="btn btn-sm btn-primary" id="add_option_edit"><i
                                                class="fa fa-plus" aria-hidden="true"></i></button>



                                    </ol>
                                </div>
                            @endif

                        </div>
                        <div class="col-sm-12" id="add_option_div_edit">
                        </div>

                    </div>
                </div>


                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="questionSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function() {

        var i = "{{ $number }}";
        // $("#add_option_edit").click(function(e) {
        $(document).on('click', '#add_option_edit', function(e) {
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

            $("#add_option_div_edit").append(html);
            i++;
        });
        $(document).on('click', '.remove-option', function() {
            $(this).closest('div#remove_option').remove();
        });


    });
</script>
