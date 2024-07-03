<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Quote</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('quote.store') }}" id="quote-frm">
                @csrf
                <?php $language = get_language(); ?>

                <div class="row g-2">
                    @foreach ($language as $key => $lang)
                        @php
                            $text_error = 'text.' . $lang['code'] . '.text';
                        @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required">{{ $lang['language'] }} Text <span class="text-danger">*</span></span>
                            </label>
                            <textarea type="text" class="form-control @error($text_error) is-invalid @enderror" id="text"
                                name="text[{{ $lang['code'] }}][text]">{{ old($text_error) }}</textarea>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="quoteSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
