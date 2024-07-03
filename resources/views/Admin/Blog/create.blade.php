<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Resource</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"  onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark needs-validation" method="post" action="{{ route('blog.store') }}"
                enctype="multipart/form-data" id="blog-frm">
                <?php $language = get_language(); ?>
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label">Key <span class="text-danger">*</span></label>
                                <input class="form-control @error('key') is-invalid @enderror" id="key" name="key"
                                type="text" placeholder="Enter Resource Key" aria-label="Blog Key">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Resource Image - <span class="text-danger"> 1000px X 700px</span> </label>
                                <input class="form-control @error('resource_image') is-invalid @enderror" id="resource_image"
                                name="resource_image" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                            <?php $categories_list = get_categories(); ?>
                            <div class="col-md-4" id="category">
                                <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                                <select name="category_id" aria-label="Select a Categories" id="category_id"
                                     class="form-select">
                                     <option value="">Select Category</option>
                                    @foreach ($categories_list as $categoty)
                                            @php
                                                    $title_array = json_decode($categoty['category_name'], true);
                                                    if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}
                                            @endphp
                                        <option value="{{ $categoty['id']}}">{{ $data_blog_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    @foreach ($language as $key => $lang)
                                <input type="hidden" name="language[{{ $key }}][language]"
                                    value="{{ $lang['code'] }}">
                                <div class="col-12" id="accordion">
                                    <hr class="dashed">
                                    <div class="form-label"> Resource Content For {{ $lang['language'] }} </div>
                                    <hr class="dashed">
                                </div>
                                @php
                                    $title_text_error = 'blog_title.' . $lang['code'] . '.blog_title';
                                @endphp

                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">Resource Title <span class="text-danger">*</span></span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error($title_text_error) is-invalid @enderror" id="blog_title"
                                        name="blog_title[{{ $lang['code'] }}][blog_title]"
                                        placeholder="Enter Resource Title for {{ $lang['language'] }}"
                                        value="{{ old($title_text_error) }}">
                                </div>
                                @php
                                    $blog_sub_title_text_error = 'blog_sub_title.' . $lang['code'] . '.blog_sub_title';
                                @endphp
                                <div class="col-md-6">
                                    <label class="col-form-label ">
                                        <span class="required">Resource Sub Title <span class="text-danger">*</span></span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error($blog_sub_title_text_error) is-invalid @enderror"
                                        id="blog_sub_title" name="blog_sub_title[{{ $lang['code'] }}][blog_sub_title]"
                                        placeholder="Enter Resource Sub Title for {{ $lang['language'] }}"
                                        value="{{ old($blog_sub_title_text_error) }}">
                                </div>
                                @php
                                    $description_text_error = 'description.' . $lang['code'] . '.description';
                                @endphp
                                <div class="col-md-12">
                                    <label class="col-form-label ">
                                        <span class="required">Description <span class="text-danger">*</span></span>
                                    </label>
                                    <textarea class="form-control @error($description_text_error) is-invalid @enderror ckeditor" id="description"
                                        name="description[{{ $lang['code'] }}][description]" placeholder="Enter Description for {{ $lang['language'] }}"></textarea>
                                </div>
                            @endforeach

                </div>




                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="blogSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close"  onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>

