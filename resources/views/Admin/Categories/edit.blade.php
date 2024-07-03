<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Category</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
                <form action="{{ route('category.update', $data->id) }}" class="form-bookmark" method="post" enctype="multipart/form-data"
                    id="category-edit-form">
                    @csrf
                    @method('PUT')

                <?php $language = get_language(); ?>
                <?php $categories = get_categories(); ?>

                <div class="row g-2">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Parent Category <span class="text-danger">*</span></label>
                        <select name="parent_id" aria-label="Select a Parent Category"
                            data-placeholder="Select a Parent Category..."
                            class="form-select">
                            <option value="0" selected="">Select Parent Category..</option>
                            @foreach ($categories as $key => $cat)
                            @php
                                $title_array = json_decode($cat['category_name'], true);
                                if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}

                            @endphp
                             <option value="{{ $cat['id'] }}" @if($data->parent_id == $cat['id']) selected @endif> {{ $data_blog_title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @foreach ($language as $key => $lang)
                            <?php $array = json_decode($data['category_name'], true); ?>
                            @php
                                $text_error = 'category_name.' . $lang['code'] . '.category_name';
                            @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required"> {{ $lang['language'] }} Text <span class="text-danger">*</span></span>
                            </label>

                            <input type="text" class="form-control @error($text_error) is-invalid @enderror" id="category_name"
                            name="category_name[{{ $lang['code'] }}][category_name]" placeholder="Category Name" value="@if (!empty($array[$lang['code']]['category_name'])){{ $array[$lang['code']]['category_name'] }}@endif">

                        </div>
                    @endforeach


                    <div class="col-sm-4">
                        <label class="form-label" for="icon">Category Icon - <span class="text-danger"> 200px * 200px</span> <span class="text-danger">*</span></label>
                        <input class="form-control" id="icon" type="file" name="icon"
                            accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label" for="icon"></label><br>
                        <img src="{{ static_asset('icon/' . $data->icon) }}" class=""
                            style="height:30px">
                    </div>



                    <div class="col-sm-4">
                        <label class="form-label" for="category_image">Category Image - <span class="text-danger"> 500px * 700px</span> <span class="text-danger">*</span></label>
                        <input class="form-control" id="category_image" type="file" name="category_image"
                            accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="col-sm-2">
                        <label class="form-label" for="category_image"></label><br>
                        <img src="{{ static_asset('category_image/' . $data->category_image) }}" class=""
                            style="height:30px">
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="categorySubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
