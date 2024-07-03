<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Subscription</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark needs-validation" method="post"
                action="{{ route('subscription.update', $data->id) }}" enctype="multipart/form-data"
                id="subscription-edit-form">
                <?php $language = get_language(); ?>
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-form-label">Subscription Key <span class="text-danger">*</span></label>
                                <input class="form-control @error('key') is-invalid @enderror" id="key"
                                    name="key" type="text" placeholder="Enter Subscription Key"
                                    aria-label="subscription Key" value="{{ $data->key }}">
                            </div>
                        </div>
                    </div>

                    @foreach ($language as $key => $lang)
                        <?php $array = json_decode($data['name'], true); ?>
                        @php
                            $text_error = 'subscription_name.' . $lang['code'] . '.subscription_name';
                        @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required"> {{ $lang['language'] }} Subscription Name <span class="text-danger">*</span></span>
                            </label>
                            <textarea type="text" class="form-control @error($text_error) is-invalid @enderror" id="subscription_name"
                                name="subscription_name[{{ $lang['code'] }}][subscription_name]">@if (!empty($array[$lang['code']]['subscription_name'])){{ $array[$lang['code']]['subscription_name'] }}
                                @endif
                                </textarea>
                        </div>
                    @endforeach

                    @foreach ($language as $key => $lang)
                        <?php $array = json_decode($data['description'], true); ?>
                        @php
                            $text_error = 'subscription_description.' . $lang['code'] . '.subscription_description';
                        @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required"> {{ $lang['language'] }} Subscription Description <span class="text-danger">*</span></span>
                            </label>
                            <textarea type="text" class="form-control @error($text_error) is-invalid @enderror" id="subscription_description"
                                name="subscription_description[{{ $lang['code'] }}][subscription_description]">@if (!empty($array[$lang['code']]['subscription_description'])){{ $array[$lang['code']]['subscription_description'] }}@endif
                                    </textarea>
                        </div>
                    @endforeach



                    <div class="col-md-6">
                        <label class="col-form-label">Select Featured</label>
                        <select name="featured" aria-label="Select a featured" id="featured"
                            data-placeholder="Select a featured..." class="form-select">
                            <option value="yes" @if($data->featured =="yes") selected="" @endif>Yes</option>
                            <option value="no"  @if($data->featured =="no") selected="" @endif>no</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required"> Duration (in-Days) <span class="text-danger">*</span></span>
                        </label>
                        <input class="form-control @error('duration') is-invalid @enderror" id="duration"
                            name="duration" type="text" placeholder="Enter duration" value="{{ $data->duration }}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">Amount <span class="text-danger">*</span></span>
                        </label>
                        <input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                            type="text" placeholder="Enter Amount"value="{{ $data['amount']}}">
                    </div>


                    <div class="col-md-6">
                        <label class="col-form-label">Select Subscription Type</label>
                        <select name="subscription_type" aria-label="Select a Subscription" id="subscription_type"
                            data-placeholder="Select a Subscription..." class="form-select subscription_type">
                            <option value="whole_system" @if($data->subscription_type =="whole_system") selected="" @endif>Whole System</option>
                            <option value="categories_wise" @if($data->subscription_type =="categories_wise") selected="" @endif>Categories Wise</option>
                        </select>
                    </div>



                    <?php $categories_list = main_categories_list(); ?>
                    <div class="col-md-6  @if($data->subscription_type =="whole_system") d-none @endif" id="category1">
                        <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                        <select name="category_id[]"  id="category_id"
                             class="form-select custom_select2" multiple>
                            @foreach ($categories_list as $categoty)
                                    @php
                                        $title_array = json_decode($categoty['category_name'], true);
                                        if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}
                                     @endphp
                                <option value="{{$categoty['id'] }}" @if($data->main_category_id != null) @if(in_array($categoty['id'],$data->main_category_id)) selected @endif @endif> {{ $data_blog_title }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subscriptionSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
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

