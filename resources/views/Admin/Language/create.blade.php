<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Language</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">
            {{-- <form class="form-bookmark"> --}}
            <form class="form-bookmark" method="post" action="{{ route('language.store') }}" id="language-frm">
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="language_code">Language Code</label>
                        <input class="form-control" id="language_code" name="language_code" type="text"
                            placeholder="Enter Language Code" aria-label="Language Code">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="language_name">Language Name</label>
                        <input class="form-control" id="language_name" name="language_name" type="text"
                            placeholder="Enter Language Name">
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="languageSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
