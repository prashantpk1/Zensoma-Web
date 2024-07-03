@extends('Admin.layouts.app')
@section('content')
    <?php
    $url = URL::to('/content');
    ?>

    <div class="container-fluid">
        <div class="page-title">
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>Update Content</h4>
                    </div>
                    <div class="card-body custom-input">
                        <form class="form-bookmark needs-validation" method="post"
                            action="{{ route('content.update', $data->id) }}" enctype="multipart/form-data"
                            id="content-frm-edit">
                            @csrf
                            @method('PUT')
                            <?php $language = get_language(); ?>
                            <?php $categories = categories_list(); ?>
                            <div class="row g-2">
                                <div class="col-md-12 mt-0">
                                    <div class="row">

                                        @foreach ($language as $key => $lang)
                                            @php
                                                $text_error = 'Title.' . $lang['code'] . '.Title';
                                                $array = json_decode($data['title'], true);
                                                $array_dec = json_decode($data['description'], true);
                                            @endphp
                                            <div class="col-md-12">
                                                <label class="col-form-label ">
                                                    <span class="required">{{ $lang['language'] }} Title <span
                                                            class="text-danger">*</span></span>
                                                </label>
                                                <input type="text" name="title[{{ $lang['code'] }}][title]"
                                                    id="key" class="form-control" placeholder="Enter Title"
                                                    @error('key') is-invalid @enderror
                                                    value="@if (!empty($array[$lang['code']]['title'])) {{ $array[$lang['code']]['title'] }} @endif">
                                            </div>


                                            <div class="col-md-12">
                                                <label class="col-form-label ">
                                                    <span class="required">{{ $lang['language'] }} Description <span
                                                            class="text-danger">*</span></span>
                                                </label>
                                                <textarea type="text" class="form-control @error($text_error) is-invalid @enderror ckeditoredit"
                                                    name="description[{{ $lang['code'] }}][description]">
                                                        @if (!empty($array_dec[$lang['code']]['description']))
                                                        {{ $array_dec[$lang['code']]['description'] }}
                                                        @endif
                                                        </textarea>

                                            </div>
                                        @endforeach


                                        <div class="col-sm-6">
                                            <label class="form-label">Content Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="content_type" aria-label="Select a Content Type"
                                                data-placeholder="Select a Content Type..." class="form-select">
                                                <option value="video" @if ($data->content_type == 'video') selected @endif>
                                                    Video</option>
                                                <option value="audio" @if ($data->content_type == 'audio') selected @endif>
                                                    Audio</option>
                                                {{-- <option value="content" @if ($data->content_type == 'content') selected @endif>
                                                    Content</option> --}}
                                            </select>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label" for="duration">Duration <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control @error('duration') is-invalid @enderror"
                                                id="duration" name="duration" type="text" placeholder="Enter Duration"
                                                value="{{ $data->duration }}">
                                        </div>


                                        <?php $tags_list = get_tag(); ?>
                                        <div class="col-md-6">
                                            <label class="form-label">Select Tag<span class="text-danger">*</span></label>
                                            <select name="tag_ids[]" id="tag_ids"
                                                class="form-select custom_select2 tag_ids" multiple>
                                                @if ($data->tag_ids != null)
                                                    @foreach ($tags_list as $tag)
                                                        @php
                                                            $title_array = json_decode($tag['tag_name'], true);
                                                            if (!empty($title_array['en']['tag_name'])) {
                                                                $tag_name = $title_array['en']['tag_name'];
                                                            } else {
                                                                $tag_name = 'No Data Found';
                                                            }
                                                        @endphp
                                                        <option value="{{ $tag['id'] }}"
                                                            @if ($data->tag_ids != null) @if (in_array($tag['id'], json_decode($data->tag_ids))) selected @endif
                                                            @endif> {{ $tag_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>




                                        {{-- <div class="col-sm-6">
                                    <label class="form-label">Purchase Type</label>
                                    <select name="purchase_type" aria-label="Select a Purchase Type"
                                        data-placeholder="Select a Purchase Type..." class="form-select">
                                        <option value="1"  @if ($data->purchase_type == 1) selected="" @endif>Indivisual</option>
                                        <option value="0" @if ($data->purchase_type == 0) selected="" @endif>Subscription</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="price">Price</label>
                                    <input class="form-control @error('price') is-invalid @enderror" id="price"
                                        name="price" type="text" placeholder="Enter Price" value="{{ $data['price']}}">
                                </div> --}}

                                        <?php $categories_list = main_categories_list(); ?>
                                        <div class="col-md-6">
                                            <label class="form-label">Select Main Categories <span
                                                    class="text-danger">*</span></label>
                                            <select name="main_category_id[]" id="main_category_id"
                                                class="form-select custom_select2 main_category_id" multiple>
                                                @if ($data->main_category_id != null)
                                                    @foreach ($categories_list as $categoty)
                                                        @php
                                                            $title_array = json_decode(
                                                                $categoty['category_name'],
                                                                true,
                                                            );
                                                            if (!empty($title_array['en']['category_name'])) {
                                                                $category_name = $title_array['en']['category_name'];
                                                            } else {
                                                                $category_name = 'No Data Found';
                                                            }
                                                        @endphp
                                                        <option value="{{ $categoty['id'] }}"
                                                            @if ($data->main_category_id != null) @if (in_array($categoty['id'], json_decode($data->main_category_id))) selected @endif
                                                            @endif> {{ $category_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <?php $categories_list = get_sub_categories_from_main($data->main_category_id); ?>
                                        <div class="col-md-6" id="category1">
                                            <label class="form-label">Select Categories <span
                                                    class="text-danger">*</span></label>
                                            <select name="category_id[]" id="category_id"
                                                class="form-select custom_select2 categoryData category_id" multiple>
                                                @if ($data->category_id != null)
                                                    @foreach ($categories_list as $categoty)
                                                        @php
                                                            $title_array = json_decode(
                                                                $categoty['category_name'],
                                                                true,
                                                            );
                                                            if (!empty($title_array['en']['category_name'])) {
                                                                $category_name = $title_array['en']['category_name'];
                                                            } else {
                                                                $category_name = 'No Data Found';
                                                            }
                                                        @endphp
                                                        <option value="{{ $categoty['id'] }}"
                                                            @if ($data->category_id != null) @if (in_array($categoty['id'], json_decode($data->category_id))) selected @endif
                                                            @endif> {{ $category_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>



                                        <div class="col-sm-6">
                                            <label class="form-label">Select Type<span class="text-danger">*</span></label>
                                            <select name="type_id" class="form-select typeData" id="typeData">
                                                <option value="">Select Type</option>
                                                @if ($data->type != null)
                                                    <option value="{{ $data->type_id }}"
                                                        @if ($data->type != null) selected @endif>
                                                        {{ $data->type }}</option>
                                                @endif
                                            </select>
                                        </div>

                                        @foreach ($data->session_videos as $key1=>$session_video)
                                        @php $session_video_array = $session_video['video_title']; @endphp

                                                    @foreach ($language as $key => $lang)
                                                        @php
                                                            $text_error = 'Title.' . $lang['code'] . '.Title';
                                                        @endphp
                                                          <div class="col-md-6">
                                                            <label class="col-form-label">
                                                                <span class="required">{{ $lang['language'] }} Title</span>
                                                            </label>
                                                                <input type="text" name="title_video[{{ $session_video->id }}][{{ $lang['code'] }}][title_video]" id="key" class="form-control" placeholder="Enter {{ $lang['language'] }} Title" @error('key') is-invalid @enderror required value="{{ $session_video_array[$lang['code']]['title_video'] }}">
                                                        </div>
                                                    @endforeach


                                            <div class="col-sm-3">
                                                <label class="form-label" for="thumbnail_image">Thumbnail - <span
                                                        class="text-danger"> 800px x 600px
                                                        (Accept:png,jpg,jpeg)</span></label>
                                                <input class="form-control" id="thumbnail_image" type="file"
                                                    name="thumbnail_image[{{ $session_video['id'] }}]" accept=".png, .jpg, .jpeg">
                                            </div>

                                             <input class="form-control" id="session_video_id" type="hidden"
                                                   name="session_video_id" value="{{ $session_video['id']}}">

                                            <div class="col-sm-2"><br>
                                                <img src='{{ static_asset('thumbnail_image') }}/{{ $session_video->thumbnail_image }}'
                                                    class="img-thumbnail brand-image img-circle elevation-3" height="50"
                                                    width="50" />
                                            </div>


                                            <div class="col-sm-3">
                                                <label class="form-label" for="file">File <span
                                                        class="text-danger">Accept = (Video/Audio)</span> <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" id="file" type="file"
                                                    name="file[{{ $session_video['id'] }}]" accept="video/*,audio/*">
                                            </div>




                                            <div class="col-sm-2"><br>
                                                {{-- <label class="form-label">Content Type</label> --}}
                                                @if ($data->content_type == 'video')
                                                    <video width="130" controls>
                                                        <source
                                                            src="{{ static_asset('file/' . $session_video->video_audio_file) }}"
                                                            type="video/mp4">
                                                        Your browser does not support HTML video.
                                                    </video>
                                                @elseif($data->content_type == 'audio')
                                                    <audio width="130" controls>
                                                        {{-- <source src="horse.ogg" type="audio/ogg"> --}}
                                                        <source
                                                            src="{{ static_asset('file/' . $session_video->video_audio_file) }}"
                                                            type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    <p>Content</p>
                                                @endif

                                            </div>

                                            <div class="col-sm-2">
                                                <br>

                                                        <a href="{{ route('remove.video', $session_video->id) }}" class="btn btn-light" onclick="return confirm('Are you sure you want to remove this video?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                            </div>
                                        @endforeach

                                        <div class="col-sm-10">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label" for="file"><br><br></label>
                                            <button type="button" class="btn btn-sm btn-primary" id="add_content"><i
                                                class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>



                                        <div class="col-sm-12" id="add_video_div_edit">
                                        </div>



                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subadminSubmit"><i
                                    class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
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
            CKEDITOR.replaceAll('ckeditoredit');



            $('#main_category_id').on('change', function() {
                var category_id = $('#main_category_id').val();
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

            $('.custom_select2').select2({
                // dropdownParent: $('#createsubscriptionmodel')
            });



            $(document).on('submit', '#content-frm-edit', function(e) {
                e.preventDefault();
                var frm = this;
                var btn = $('#subadminSubmit');
                var url = $(this).attr('action');
                var formData = new FormData(frm);

                //for button  to set  progress
                jQuery('.btn-custom').addClass('disabled');
                jQuery('.icon').removeClass('d-none');


                formData.append("_method", 'PATCH');

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
                        // location.reload();

                        var content = "{{ $url }}";

                        window.setTimeout(function() {
                            window.location.href = content;
                        }, 300);

                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');


                    },
                    error: function(xhr) {
                        // $('#send').button('reset');
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



            var i = 0;
            $("#add_content").click(function(e) {
                var html = '';
                html += `<div class="row" id="remove_content">`;

                    @foreach ($language as $key => $lang)
                    html += `<div class="col-md-6">
                            <label class="col-form-label">
                                <span class="required">` + "{{ $lang['language'] }}" + ` Title</span>
                            </label>
                            <input type="text" name="title_video_new[`+ i +`][` + "{{ $lang['code'] }}" + `][title_video]" id="key" class="form-control" placeholder="Enter Title" @error('key') is-invalid @enderror required>
                        </div>`;
                    @endforeach

                html += `<div class="col-md-5">
                        <label class="col-form-label">
                            <span class="text-danger"> 800px x 600px  (Accept:png,jpg,jpeg)</span>
                        </label>
                            <input type="file" name="thumbnail_image_new[]" id="thumbnail_image" class="form-control" @error('thumbnail_image') is-invalid @enderror accept=".png, .jpg, .jpeg" required>
                    </div>`;

                html += `<div class="col-md-5">
                        <label class="col-form-label">
                            <span class="text-danger">Accept = (Video/Audio)</span> <span class="text-danger">*</span>
                        </label>
                            <input type="file" name="file_new[]" id="file" class="form-control" @error('file') is-invalid @enderror accept="video/*,audio/*" required>
                    </div>`;

                html +=
                    `<div class="col-sm-2">
                       <br>
                        <button type="button" class="btn btn-sm btn-primary remove-content"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>`

                $("#add_video_div_edit").append(html);
                i++;
            });
            $(document).on('click', '.remove-content', function() {
                $(this).closest('div#remove_content').remove();
            });


        });
    </script>
@endsection
