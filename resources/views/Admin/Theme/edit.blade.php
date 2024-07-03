<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Theme</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('theme.update',$data->id) }}" id="theme-edit-form" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row g-2">

                    <?php $language = get_language(); ?>

                    @foreach ($language as $key => $lang)

                        @php
                            $text_error = 'Title.' . $lang['code'] . '.Title';
                            $array = json_decode($data['title'], true);
                            $array_dec = json_decode($data['description'], true);
                        @endphp
                        <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Title <span class="text-danger">*</span></span>
                            </label>
                                <input type="text" name="title[{{ $lang['code'] }}][title]" id="key" class="form-control" placeholder="Enter Title" @error('key') is-invalid @enderror value="@if (!empty($array[$lang['code']]['title'])){{ $array[$lang['code']]['title'] }} @endif">
                        </div>

                    @endforeach


                    <div class="col-sm-9">
                        <label class="form-label" for="thumbnail">Thumbnail <span class="text-danger"> 1080px X 1920px (Accept:png,jpg,jpeg)</span></label>
                        <input class="form-control" id="thumbnail" type="file" name="thumbnail"
                        accept=".jpg">
                    </div>

                    <div class="col-sm-3"><br>
                        <img src='{{ static_asset('thumbnail_image') }}/{{ $data->thumbnail }}'
                        class="img-thumbnail brand-image img-circle elevation-3" height="40"
                        width="40"  accept=".jpg"/>
                    </div>


                    <div class="col-sm-9">
                        <label class="form-label" for="file">File <span class="text-danger"> 10 Sec to 1 min (Accept:mp4)</span></label>
                        <input class="form-control" id="file" type="file" name="file" accept=".mp4">
                    </div>




                    <div class="col-sm-3"><br>
                        <video width="40" controls>
                            <source src="{{ static_asset('file/' . $data->file) }}" type="video/mp4">
                                    Your browser does not support HTML video.
                        </video>
                    </div>


                </div>




                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="themeSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
