<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Gamification Config</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <?php $language = get_language(); ?>
        <div class="modal-body" id="myModal">
            {{-- <form class="form-bookmark"> --}}
            <form class="form-bookmark" method="post" action="{{ route('gamification-config.update',$data->id) }}" id="gamification-config-edit-form">
                @csrf
                @method('put')
                <div  class="row">

                    
                    @foreach ($language as $key => $lang)
                            <?php $array = json_decode($data['config_name'], true); ?>
                            @php
                                $text_error = 'config_name.' . $lang['code'] . '.config_name';
                            @endphp
                        <div class="mb-3 col-md-6">
                            <label class="col-form-label ">
                                <span class="required"> {{ $lang['language'] }} Gamification Config Name <span class="text-danger">*</span></span>
                            </label>
                            <input type="input" class="form-control @error($text_error) is-invalid @enderror" id="config_name"
                            name="config_name[{{ $lang['code'] }}][config_name]" value="@if (!empty($array[$lang['code']]['config_name'])){{ $array[$lang['code']]['config_name'] }}@endif">
                        </div>
                    @endforeach
                  



                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value">Congfig Key<span class="text-danger">*</span></label>
                    <input class="form-control" id="config_key" name="config_key" type="text"
                        placeholder="Enter Congfig Key" aria-label="Congfig Key" value="{{ $data->config_key }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label" for="value"> Config Value<span class="text-danger">*</span></label>
                    <input class="form-control" id="config_value" name="config_value" type="text"
                        placeholder="Enter Config Value" aria-label="Config Value" value="{{ $data->config_value }}">
                </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="gamification-configSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i>  Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
