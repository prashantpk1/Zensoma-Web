<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Sub Admin</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark needs-validation" method="post"
                action="{{ route('question.update', $data->id) }}" enctype="multipart/form-data" id="question-edit-frm">
                @csrf
                @method('put')
                <?php $language = get_language(); ?>
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">

                            @foreach ($language as $key => $lang)
                                @php
                                    $array = json_decode($data['question'], true);
                                    $text_error = 'Question.' . $lang['code'] . '.Question';
                                @endphp
                                <div class="col-md-6">
                                    <label class="col-form-label">
                                        <span class="required">{{ $lang['language'] }} Question</span>
                                    </label>
                                    <input type="text" name="question[{{ $lang['code'] }}][question]" id="key"
                                        class="form-control" placeholder="Enter Question"
                                        @error('key') is-invalid @enderror
                                        value="@if (!empty($array[$lang['code']]['question'])) {{ $array[$lang['code']]['question'] }} @endif">
                                </div>
                            @endforeach


                            <div class="col-md-12">
                                <label class="form-label" for="coupon_code">Option Type</label>
                                <select name="option_type" id="option_type" aria-label="Select a Option Type"
                                    data-placeholder="Select a Option Type..." class="form-select form-control">
                                    <option value="checkbox" @if ($data->option_type == 'checkbox') selected="" @endif>Check
                                        Box</option>
                                    <option value="range" @if ($data->option_type == 'range') selected="" @endif>Range
                                    </option>
                                    <option value="radio" @if ($data->option_type == 'radio') selected="" @endif>Radio
                                    </option>
                                </select>
                            </div>

                            @php $total_option = 1;
                                $i = 0;
                            @endphp
                            @if ($data->options != null)

                            {{-- @foreach ($language as $lang) --}}
                                {{-- @php
                                    $array = json_decode($data['options'], true)[$lang['code']];
                                    $text_error = 'options.' . $lang['code'] . '.options';

                                @endphp
                                    @foreach ($array as $option)

                                            <div class="col-md-6">
                                            <label class="col-form-label">
                                                <span class="required">{{ $lang['language'] }} options</span>
                                            </label>
                                                <input type="text" name="option[{{ $lang['code'] }}][option{{ $i }}]" id="key" class="form-control" placeholder="Enter options" @error('key') is-invalid @enderror value="@if (!empty($option)){{ $option }}@endif" required>
                                        </div>

                                        @php $i++ @endphp
                                    @endforeach

                            @endforeach --}}

                                @php
                                $dataArray = json_decode($data['options'], true);

                                $englishOptions = $dataArray['en'];
                                @endphp


                                {{-- // dd($language,$englishOptions,$dataArray['ar']);
                                // Print options side by side --}}
                                @foreach ($englishOptions as $key => $englishOption)
                                    {{-- echo "En Option $key: $englishOption\n"; --}}

                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">{{ $lang['language'] }} Option</span>
                                        </label>
                                        <input type="text" name="option[{{ $lang['code'] }}][option0]" id="key"
                                            class="form-control" placeholder="Enter Option"
                                            @error('key') is-invalid @enderror required value="{{ $englishOption }}">
                                    </div>

                                    @foreach ($language as $lang)
                                        {{-- // Check if the corresponding English option exists --}}
                                        @if($lang['code'] != $defultLanguage)
                                            @if(isset($dataArray[$lang['code']]))
                                            <div class="col-md-6">
                                                <label class="col-form-label">
                                                    <span class="required">{{ $lang['language'] }} Option</span>
                                                </label>
                                                <input type="text" name="option[{{ $lang['code'] }}][option0]" id="key"
                                                    class="form-control" placeholder="Enter Option"
                                                    @error('key') is-invalid @enderror required value="{{ $dataArray[$lang['code']][$key] }}">
                                            </div>
                                            @endif
                                        @endif
                                    @endforeach

                                @endforeach
                            @else
                                @foreach ($language as $key => $lang)
                                    @php
                                        $text_error = 'option.' . $lang['code'] . '.option';
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">{{ $lang['language'] }} Option</span>
                                        </label>
                                        <input type="text" name="option[{{ $lang['code'] }}][option0]" id="key"
                                            class="form-control" placeholder="Enter Option"
                                            @error('key') is-invalid @enderror required>
                                    </div>
                                @endforeach
                            @endif
                            <div class="col-10">

                            </div>
                            <div class="col-2">
                                <ol class="breadcrumb">

                                    <button type="button" class="btn btn-sm btn-primary" id="add_option_edit"><i
                                            class="fa fa-plus" aria-hidden="true"></i></button>



                                </ol>
                            </div>

                        </div>
                        <div class="col-sm-12" id="add_option_div_edit">
                        </div>

                    </div>
                </div>


                <button class="btn btn-primary btn-sm" type="submit" id="questionSubmit">Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function() {

        var i = "{{ $i }}";
        // $("#add_option_edit").click(function(e) {
        $(document).on('click', '#add_option_edit', function(e) {
            var html = '';
            html += `<div class="row" id="remove_option">`;
            @foreach ($language as $key => $lang)
                html += `<div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">` + "{{ $lang['language'] }}" + ` Option</span>
                        </label>
                            <input type="text" name="option[` + "{{ $lang['code'] }}" + `][option` + i + `]" id="key" class="form-control" placeholder="Enter Option" @error('key') is-invalid @enderror required>
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
