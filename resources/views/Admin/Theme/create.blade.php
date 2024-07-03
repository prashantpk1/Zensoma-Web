<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Theme</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('theme.store') }}" id="theme-frm" enctype="multipart/form-data">
                @csrf

                <?php $language = get_language(); ?>

                <div class="row g-2">
                    @foreach ($language as $key => $lang)
                        @php
                            $text_error = 'text.' . $lang['code'] . '.text';
                        @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Theme Title <span class="text-danger">*</span></span>
                            </label>
                                <input class="form-control" id="title" type="text" name="title[{{ $lang['code'] }}][title]" value="{{ old($text_error) }}">
                        </div>
                    @endforeach



                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="thumbnail">Thumbnail <span class="text-danger"> 1080px X 1920px (Accept:png,jpg,jpeg)</span> </label>
                        <input class="form-control" id="thumbnail" type="file" name="thumbnail"
                        accept=".jpg">
                    </div>

                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="file">File  <span class="text-danger"> 10 Sec to 1 min (Accept:mp4)</span></label>
                        <input class="form-control" id="file" type="file" name="file"
                        accept=".mp4">
                    </div>

                </div>


                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="themeSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
