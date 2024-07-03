<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Subscription</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark needs-validation" method="post" action="{{ route('subscription.store') }}"
                enctype="multipart/form-data" id="subscription-frm">
                <?php $language = get_language(); ?>
                @csrf
                <div class="row g-3">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-form-label">Subscription Key <span class="text-danger">*</span></label>
                                <input class="form-control @error('key') is-invalid @enderror" id="key"
                                    name="key" type="text" placeholder="Enter Subscription Key"
                                    aria-label="subscription Key">
                            </div>
                        </div>
                    </div>


                    @foreach ($language as $key => $lang)
                        <input type="hidden" name="language[{{ $key }}][language]"
                            value="{{ $lang['code'] }}">
                        @php
                            $title_text_error = 'subscription_name.' . $lang['code'] . '.subscription_name';
                        @endphp

                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Subscription Name <span class="text-danger">*</span></span>
                            </label>
                            <input type="text" class="form-control @error($title_text_error) is-invalid @enderror"
                                id="subscription_name" name="subscription_name[{{ $lang['code'] }}][subscription_name]"
                                placeholder="Enter Subscription Name for {{ $lang['language'] }}"
                                value="{{ old($title_text_error) }}">
                        </div>
                    @endforeach
                    @foreach ($language as $key => $lang)
                        @php
                            $subscription_description_text_error = 'subscription_description.' . $lang['code'] . '.subscription_description';
                        @endphp
                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Subscription Description <span class="text-danger">*</span></span>
                            </label>

                            <textarea type="text" class="form-control @error($subscription_description_text_error) is-invalid @enderror"
                                id="text" d="subscription_description"
                                name="subscription_description[{{ $lang['code'] }}][subscription_description]"></textarea>


                        </div>
                    @endforeach



                    <div class="col-md-6">
                        <label class="col-form-label">Select Featured <span class="text-danger">*</span></label>
                        <select name="featured" aria-label="Select a featured" id="featured"
                            data-placeholder="Select a featured..." class="form-select">
                            <option value="yes">Yes</option>
                            <option value="no">no</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required"> Duration (in-Days) <span class="text-danger">*</span></span>
                        </label>
                        <input class="form-control @error('duration') is-invalid @enderror" id="duration"
                            name="duration" type="text" placeholder="Enter duration">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required"> Amount <span class="text-danger">*</span></span>
                        </label>
                        <input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                            type="text" placeholder="Enter Amount">
                    </div>



                    <div class="col-md-6">
                        <label class="col-form-label">Select Subscription Type</label>
                        <select name="subscription_type" aria-label="Select a Subscription" id="subscription_type"
                            data-placeholder="Select a Subscription..." class="form-select">
                            <option value="whole_system">Whole System</option>
                            <option value="categories_wise">Categories Wise</option>
                        </select>
                    </div>



                    <?php $categories_list = main_categories_list(); ?>

                    <div class="col-md-6 d-none" id="category">
                        <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                        <select name="category_id[]" aria-label="Select a Categories" id="category_id"
                             class="form-select custom_select2" multiple>
                            @foreach ($categories_list as $categoty)
                                    @php
                                            $title_array = json_decode($categoty['category_name'], true);
                                            if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}
                                    @endphp
                                <option class="select2-selection__rendered" value="{{ $categoty['id']}}">{{ $data_blog_title }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subscriptionSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>



<script>
      $('.custom_select2').select2({
            // dropdownParent: $('#createsubscriptionmodel')
      });
</script>
