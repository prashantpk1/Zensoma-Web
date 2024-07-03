<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Cms Page</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark" method="post" action="{{ route('cms.update',$data->id) }}" id="cms-edit-frm">
                @csrf
                @method('put')
                <?php $language = get_language(); ?>

                <div class="row g-2">

                    <?php $title = json_decode($data['title'], true); ?>
                    <?php $content = json_decode($data['content'], true); ?>
                    @foreach ($language as $key => $lang)
                    <div class="col-md-12">
                        <label class="col-form-label">
                            <span class="required">{{ $lang['language'] }} Title <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="title[{{ $lang['code'] }}][title]" id="key" class="form-control" placeholder="Enter Title" @error('key') is-invalid @enderror value="@if (!empty($title[$lang['code']]['title'])) {{ $title[$lang['code']]['title'] }} @endif">
                    </div>
                    <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Content <span class="text-danger">*</span></span>
                            </label>
                            <textarea  class="form-control  ckeditoredit" id="content"
                                name="content[{{ $lang['code'] }}][content]">@if (!empty($content[$lang['code']]['content'])) {{ $content[$lang['code']]['content'] }} @endif</textarea>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="cmsSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replaceAll('ckeditoredit');
    });
</script>
