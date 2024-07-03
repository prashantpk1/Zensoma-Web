<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Level</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <?php $language = get_language();?>

        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('level.store') }}" id="level-frm">
                @csrf
                <div  class="row">

                    @foreach ($language as $key => $lang)
                    @php
                        $text_error = 'text.' . $lang['code'] . '.text';
                    @endphp
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="level_name">Level Name For {{ $lang['language'] }}<span class="text-danger">*</span> </label>
                            <input class="form-control" id="level_name" name="level_name[{{ $lang['code'] }}][level_name]" type="text"
                                placeholder="Enter Level Name" aria-label="Level Name">
                        </div>
                    @endforeach


                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Level Start Minute<span class="text-danger">*</span></label>
                    <input class="form-control" id="level_minute_start" name="level_minute_start" type="text"
                        placeholder="Enter Level Start Minute" aria-label="Level Start Minute">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Level End Minute <span class="text-danger">*</span></label>
                    <input class="form-control" id="level_minute_end" name="level_minute_end" type="text"
                        placeholder="Enter Level End Minute" aria-label="Level End Minute">
                </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="levelSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
