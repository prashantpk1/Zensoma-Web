<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Category Type</h5>
            <button class="btn-close close_model_popup" type="button" data-bs-dismiss="modal" aria-label="Close" id="is_close" onclick="return close_or_clear_refresh();"></button>
        </div>
        <div class="modal-body" id="myModal">
             <form class="form-bookmark" method="post" action="{{ route('category-type.store') }}" id="category-type-frm">
                @csrf
                <div class="row g-2">

                    <?php $categories_list = main_categories_list(); ?>
                    <?php $language = get_language(); ?>

                    <div class="col-md-6" id="category">
                        <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                        <select name="main_category_id[]" aria-label="Select a Categories" id="main_category"
                            class="form-select custom_select2 js-example-basic-multiple main_category" multiple>
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


                    <div class="col-md-6">
                        <label class="form-label">Select Sub Category <span class="text-danger">*</span></label>
                        <select name="category_id" aria-label="Select a Categories" id="category_id"
                            class="form-select custom_select2 categoryData">
                            <option value="">Select Sub Category</option>
                        </select>
                    </div>


                    @foreach ($language as $key => $lang)
                    @php
                        $text_error = 'name.' . $lang['code'] . '.name';
                    @endphp
                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ $lang['language'] }} Type Name <span class="text-danger">*</span></span>
                        </label>

                        <input type="text" class="form-control @error($text_error) is-invalid @enderror"
                            id="type" name="type[{{ $lang['code'] }}][type]"
                            placeholder="Category Name">

                    </div>
                @endforeach


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="couponSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear_refresh();">Close</button>
            </form>
        </div>
    </div>
</div>
