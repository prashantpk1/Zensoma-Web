@extends('Admin.layouts.app')
@section('content')
    <?php
    $url = URL::to('/content');
    ?>
    <div class="container-fluid">
        <div class="page-title">
            {{-- <div class="row">
        <div class="col-6">
          <h4></h4>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">
                <svg class="stroke-icon">
                  <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                </svg></a></li>
            <li class="breadcrumb-item">Acoount Setting</li>
            <li class="breadcrumb-item active">s</li>
          </ol>
        </div>
      </div> --}}
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>Add Content</h4>
                    </div>
                    <div class="card-body custom-input">
                        <form class="form-bookmark " method="post" action="{{ route('content.store') }}"
                            enctype="multipart/form-data" id="content-frm">
                            @csrf
                            <?php $language = get_language(); ?>
                            <?php $categories = categories_list(); ?>
                            <div class="row g-2">
                                <div class="col-md-12 mt-0">
                                    <div class="row">
                                        @foreach ($language as $key => $lang)
                                            @php
                                                $text_error = 'Title.' . $lang['code'] . '.Title';
                                            @endphp
                                            <div class="col-md-12">
                                                <label class="col-form-label">
                                                    <span class="required">{{ $lang['language'] }} Title <span
                                                            class="text-danger">*</span></span>
                                                </label>
                                                <input type="text" name="title[{{ $lang['code'] }}][title]"
                                                    id="key" class="form-control" placeholder="Enter Title"
                                                    @error('key') is-invalid @enderror>
                                            </div>


                                            <div class="col-md-12">
                                                @php
                                                    $text_error = 'Description.' . $lang['code'] . '.Description';
                                                @endphp
                                                <label class="col-form-label ">
                                                    <span class="required">{{ $lang['language'] }} Description <span
                                                            class="text-danger">*</span></span>
                                                </label>
                                                <textarea type="text" class="form-control @error($text_error) is-invalid @enderror ckeditor"
                                                    name="description[{{ $lang['code'] }}][description]">{{ old($text_error) }}</textarea>

                                            </div>
                                        @endforeach


                                        <div class="col-sm-6">
                                            <label class="form-label">Content Type</label>
                                            <select name="content_type" aria-label="Select a Content Type"
                                                data-placeholder="Select a Content Type..." class="form-select">
                                                <option value="video">Video</option>
                                                <option value="audio">Audio</option>
                                                {{-- <option value="content">Content</option>  --}}
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label" for="duration">Duration <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control @error('duration') is-invalid @enderror"
                                                id="duration" name="duration" type="text" placeholder="Enter Duration">
                                        </div>



                                        <?php $tag_list = get_tag(); ?>

                                        <div class="col-md-6" id="tag">
                                            <label class="form-label">Select Tag <span class="text-danger">*</span></label>
                                            <select name="tag_ids[]" aria-label="Select a Categories" id="tag_ids"
                                                class="form-select custom_select2 js-example-basic-multiple tag_ids"
                                                multiple>
                                                @foreach ($tag_list as $tag)
                                                    @php
                                                        $title_array = json_decode($tag['tag_name'], true);
                                                        if (!empty($title_array['en']['tag_name'])) {
                                                            $data_tag = $title_array['en']['tag_name'];
                                                        } else {
                                                            $data_tag = 'No Data Found';
                                                        }
                                                    @endphp
                                                    <option value="{{ $tag['id'] }}">{{ $data_tag }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <?php $categories_list = main_categories_list(); ?>

                                        <div class="col-md-6" id="category">
                                            <label class="form-label">Select Categories <span
                                                    class="text-danger">*</span></label>
                                            <select name="main_category_id[]" aria-label="Select a Categories"
                                                id="main_category"
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


                                        <div class="col-md-6">
                                            <label class="form-label">Select Categories <span
                                                    class="text-danger">*</span></label>
                                            <select name="category_id[]" aria-label="Select a Categories" id="category_id"
                                                class="form-select custom_select2 js-example-basic-multiple categoryData"
                                                multiple>
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label">Select Type <span class="text-danger">*</span></label>
                                            <select name="type_id" aria-label="Select a Select Type"
                                                data-placeholder="Select a Select Type..."
                                                class="form-select custom_select2 typeData" id="typeData">
                                            </select>
                                        </div>

                                        @foreach ($language as $key => $lang)
                                        <div class="col-md-6">
                                            <label class="col-form-label">
                                                <span class="required">{{ $lang['language'] }} Title</span>
                                            </label>
                                                <input type="text" name="title_video[0][{{ $lang['code'] }}][title_video]" id="key" class="form-control" placeholder="Enter {{ $lang['language'] }} Title" @error('key') is-invalid @enderror required>
                                        </div>
                                        @endforeach

                                        <div class="col-sm-5">
                                            <label class="form-label" for="thumbnail_image">Thumbnail- <span
                                                    class="text-danger"> 800px x 600px (Accept:png,jpg,jpeg)</span> </label>
                                            <input class="form-control" id="thumbnail_image" type="file"
                                                name="thumbnail_image[]" accept=".png, .jpg, .jpeg" required>
                                        </div>

                                        <div class="col-sm-5">
                                            <label class="form-label" for="file">File<span class="text-danger">Accept =
                                                    (Video/Audio)</span> <span class="text-danger">*</span></label>
                                            <input class="form-control" id="file" type="file" name="file[]"
                                                accept="video/*,audio/*" required>
                                        </div>


                                        <div class="col-sm-2">
                                            <label class="form-label" for="file"><br><br></label>
                                            <button type="button" class="btn btn-sm btn-primary" id="add_content"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>

                                        <div class="col-sm-12" id="add_content_div">
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary btn-sm btn-custom" type="submit" id="contentSubmit"> <i
                                    class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                            <a href="{{ route('content.index') }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script src="{{ static_asset('admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/theme-customizer/customizer.js') }}"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('submit', '#content-frm', function(e) {
                e.preventDefault();
                var frm = this;
                var btn = $('#contentSubmit');
                var url = $(this).attr('action');
                var formData = new FormData(frm);

                // for button
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
                        show_toster(response.success)
                        frm.reset();

                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');

                        var content = "{{ $url }}";

                        window.setTimeout(function() {
                            window.location.href = content;
                        }, 300);


                        // location.reload();
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


            $('#main_category').on('change', function() {
                var category_id = $('#main_category').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{ route('sub.category.list') }}",
                    data: {
                        category_id: category_id
                    },
                    success: function(response) {
                        $('.categoryData').empty();
                        jQuery.each(response, function(index, item) {
                            $('.categoryData').append(' <option value=' + item['id'] +
                                ' >' + item['category_name_en'] + '</option>  ')
                        });
                    }
                });
            });





            $('#category_id').on('change', function() {
                var category = $('#category_id').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{ route('get-type') }}",
                    data: {
                        category: category
                    },
                    success: function(response) {
                        $('#typeData').empty();
                        jQuery.each(response, function(index, item) {
                            $('#typeData').append(' <option value=' + item['id'] +
                            ' >' + item['type_name_en'] + '</option>  ')
                        });
                    }
                });
            });



           var i = 1;
            $("#add_content").click(function(e) {
                var html = '';
                var category = $('#category_id').val();
                html += `<div class="row" id="remove_content">`;
                    @foreach ($language as $key => $lang)
                    html += `<div class="col-md-6">
                        <label class="col-form-label">
                            <span class="required">` + "{{ $lang['language'] }}" + ` Title</span>
                        </label>
                        <input type="text" name="title_video[`+ i +`][` + "{{ $lang['code'] }}" + `][title_video]" id="key" class="form-control" placeholder="Enter Title" @error('key') is-invalid @enderror required>
                    </div>`;
                @endforeach


                html += `<div class="col-md-5">
                        <label class="col-form-label">
                            <span class="text-danger"> 800px x 600px  (Accept:png,jpg,jpeg)</span>
                        </label>
                            <input type="file" name="thumbnail_image[]" id="thumbnail_image" class="form-control" @error('thumbnail_image') is-invalid @enderror accept=".png, .jpg, .jpeg" required>
                    </div>`;

                html += `<div class="col-md-5">
                        <label class="col-form-label">
                            <span class="text-danger">Accept = (Video/Audio)</span> <span class="text-danger">*</span>
                        </label>
                            <input type="file" name="file[]" id="file" class="form-control" @error('file') is-invalid @enderror accept="video/*,audio/*" required>
                    </div>`;

                html +=
                    `<div class="col-sm-2">
                       <br>
                        <button type="button" class="btn btn-sm btn-primary remove-content"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>`

                $("#add_content_div").append(html);
                i++;
            });
            $(document).on('click', '.remove-content', function() {
                $(this).closest('div#remove_content').remove();
            });





        });
    </script>
@endsection
