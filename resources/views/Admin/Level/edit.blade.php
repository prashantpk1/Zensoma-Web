<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Level</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <?php $language = get_language();?>
        <div class="modal-body" id="myModal">
            {{-- <form class="form-bookmark"> --}}
            <form class="form-bookmark" method="post" action="{{ route('level.update',$data->id) }}" id="level-edit-form">
                @csrf
                @method('put')
                <div  class="row">


                        @foreach ($language as $key => $lang)
                                <?php $array = json_decode($data['level_name'], true);?>
                                @php
                                    $text_error = 'level_name.' . $lang['code'] . '.level_name';
                                @endphp
                            <div class="mb-3 col-md-6">
                                <label class="col-form-label ">
                                    <span class="required"> Level Name For {{ $lang['language'] }} <span class="text-danger">*</span></span>
                                </label>
                                <input type="input" class="form-control @error($text_error) is-invalid @enderror" id="level_name"
                                name="level_name[{{ $lang['code'] }}][level_name]" value="@if (!empty($array[$lang['code']]['level_name'])){{ $array[$lang['code']]['level_name'] }}@endif">
                            </div>
                        @endforeach




                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Level Start Minute<span class="text-danger">*</span></label>
                    <input class="form-control" id="level_minute_start" name="level_minute_start" type="text"
                        placeholder="Enter Level Start Minute" aria-label="Level Start Minute" value="{{ $data->level_minute_start }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Level End Minute <span class="text-danger">*</span></label>
                    <input class="form-control" id="level_minute_end" name="level_minute_end" type="text"
                        placeholder="Enter Level End Minute" aria-label="Level End Minute" value="{{ $data->level_minute_end }}">
                </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="levelSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i>  Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
