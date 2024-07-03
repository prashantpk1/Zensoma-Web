<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Gamification Config</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <?php $language = get_language(); ?>

        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('gamification-config.store') }}" id="config-frm">
                @csrf
                <div  class="row">
              
                    @foreach ($language as $key => $lang)
                    @php
                        $text_error = 'text.' . $lang['code'] . '.text';
                    @endphp
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="config_name">Gamification Config For {{ $lang['language'] }}<span class="text-danger">*</span> </label>
                            <input class="form-control" id="config_name" name="config_name[{{ $lang['code'] }}][config_name]" type="text"
                                placeholder="Enter Gamification Config" aria-label="Gamification Config">
                        </div>
                    @endforeach
              
                    
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Gamification Config Key<span class="text-danger">*</span></label>
                    <input class="form-control" id="config_key" name="config_key" type="text"
                        placeholder="Enter Gamification Config Key" aria-label="Gamification Config Key">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Gamification Config Value <span class="text-danger">*</span></label>
                    <input class="form-control" id="config_value" name="config_value" type="text"
                        placeholder="Enter Gamification Config Value" aria-label="Gamification Config Value">
                </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="levelSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
