<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Keys and Contents for App</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">
                <form action="{{ route('multi-language.update', $data->id) }}" class="form-bookmark" method="post" enctype="multipart/form-data"
                    id="multi-language-edit-form">
                    @csrf
                    @method('PUT')

                <?php $language = get_language(); ?>

                <div class="row g-2">
                     <div class="mb-3 col-md-12">
                        <label class="col-form-label ">
                            <span class="required">Key <span class="text-danger">*</span></span>
                        </label>
                       <input type="text" name="key" id="key" class="form-control" value="{{ $data['key'] }}" placeholder="Enter Unique Key" @error('key') is-invalid @enderror readonly>
                     </div>

                    @foreach ($language as $key => $lang)
                            <?php $array = json_decode($data['content'], true); ?>
                            @php
                                $text_error = 'content.' . $lang['code'] . '.content';
                            @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required"> {{ $lang['language'] }} Text <span class="text-danger">*</span></span>
                            </label>
                            <textarea type="text" class="form-control @error($text_error) is-invalid @enderror"
                            name="content[{{ $lang['code'] }}][content]">@if (!empty($array[$lang['code']]['content'])){{ $array[$lang['code']]['content'] }}@endif</textarea>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary btn-sm btn-custom"  type="submit" id="multiLanguageSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
