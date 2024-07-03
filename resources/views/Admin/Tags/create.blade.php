<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Tag</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('tag.store') }}" id="tag-frm">
                @csrf
                <?php $language = get_language(); ?>
                <div class="row">

                            
                                @foreach ($language as $key => $lang)
                                    @php
                                        $text_error = 'tag_name.' . $lang['code'] . '.tag_name';
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label class="col-form-label ">
                                            <span class="required">Tag Name For {{ $lang['language'] }}<span class="text-danger">*</span></span>
                                        </label>
                                        <input type="text" class="form-control @error($text_error) is-invalid @enderror" id="tag_name"
                                            name="tag_name[{{ $lang['code'] }}][tag_name]"  placeholder="Enter Tag Name">
                                    </div>
                                @endforeach
                          

                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="value">Emoji Icon <span class="text-danger"> 50px X 50px (Accept:png,jpg,jpeg)</span></label>
                                <input class="form-control" id="emoji_icon" name="emoji_icon" type="file" accept=".png, .jpg, .jpeg">
                            </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="tagSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
