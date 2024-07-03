<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit Language</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">

                <form action="{{ route('language.update', $data->id) }}" method="post" enctype="multipart/form-data"
                    id="language-edit-form" class="form-bookmark">
                    @csrf
                    @method('PUT')

                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="language_code">Language Code</label>
                                    <input class="form-control @error('language_code') is-invalid @enderror"
                                        id="language_code" name="language_code" type="text"
                                        placeholder="Enter Language Code" aria-label="Language Code" value="{{ $data->code  }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="language_name">Language Name</label>
                                    <input class="form-control @error('language_name') is-invalid @enderror"
                                        id="language_name" name="language_name" type="text"
                                        placeholder="Enter Language Name" value="{{ $data->language }}">
                        </div>

                    </div>
                    <button class="btn btn-primary btn-sm btn-custom" type="submit" id="languageSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                    <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
                </form>
        </div>
    </div>
</div>
