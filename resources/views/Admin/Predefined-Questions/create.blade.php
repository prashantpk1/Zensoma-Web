<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"  onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">
            <form class="form-bookmark needs-validation" method="post" action="{{ route('question.store') }}"
                enctype="multipart/form-data" id="question-frm">
                @csrf
                <?php $language = get_language(); ?>
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row g-3">


                            <?php $categories_list = main_categories_list(); ?>

                            <div class="col-md-12" id="category">
                                <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                                <select name="category_id[]" aria-label="Select a Categories"
                                    id="category_id"
                                    class="form-select custom_select2 js-example-basic-multiple main_category"
                                    multiple>
                                    @foreach ($categories_list as $categoty)
                                        @php
                                            $title_array = json_decode($categoty['category_name'], true);
                                            if (!empty($title_array['en']['category_name'])) {
                                                $data_category = $title_array['en']['category_name'];
                                            } else {
                                                $data_category = 'No Data Found';
                                            }
                                        @endphp
                                        <option value="{{ $categoty['id'] }}">{{ $data_category }}</option>
                                    @endforeach
                                </select>
                            </div>


                            @foreach ($language as $key => $lang)
                            @php
                                $text_error = 'Question.' . $lang['code'] . '.Question';
                            @endphp

                            <div class="col-md-6">
                                <label class="col-form-label">
                                    <span class="required">{{ $lang['language'] }} Question Description <span class="text-danger">*</span></span>
                                </label>
                                <textarea type="text" name="description[{{ $lang['code'] }}][description]" id="key"
                                    class="form-control"
                                    @error('key') is-invalid @enderror></textarea>
                            </div>

                        @endforeach


                            @foreach ($language as $key => $lang)
                                @php
                                    $text_error = 'Question.' . $lang['code'] . '.Question';
                                @endphp
                                <div class="col-md-6">
                                    <label class="col-form-label">
                                        <span class="required">{{ $lang['language'] }} Question <span class="text-danger">*</span></span>
                                    </label>
                                    <input type="text" name="question[{{ $lang['code'] }}][question]" id="key"
                                        class="form-control" placeholder="Enter Question"
                                        @error('key') is-invalid @enderror>
                                </div>



                            @endforeach

                            <div class="col-md-12">
                                <label class="form-label" for="coupon_code">Option Type <span class="text-danger">*</span></label>
                                <select name="option_type" id="option_type" aria-label="Select a Option Type"
                                    data-placeholder="Select a Option Type..." class="form-select form-control">
                                    <option value="checkbox">Check Box</option>
                                    <option value="range">Range</option>
                                    <option value="radio">Radio</option>
                                </select>
                            </div>


                            <div class="row" id="radio">
                                @foreach ($language as $key => $lang)
                                    @php
                                        $text_error = 'option.' . $lang['code'] . '.option';
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="col-form-label">
                                            <span class="required">{{ $lang['language'] }} Option <span class="text-danger">*</span></span>
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



                            <div class="row d-none" id="range">
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
                        <div class="col-sm-12" id="add_option_div">
                        </div>

                    </div>
                </div>


                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="questionSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
