<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Badge</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"
                onclick="return close_or_clear();"></button>
        </div>
        <?php $language = get_language(); ?>
        <div class="modal-body" id="myModal">
            <form action="{{ route('badge.update', $data->id) }}" class="form-bookmark" method="post"
                enctype="multipart/form-data" id="badge-edit-form">
                @csrf
                @method('PUT')
                <div class="row">

                   

                    
                        @foreach ($language as $key => $lang)
                            <?php $array = json_decode($data['badge_name'], true); ?>
                            @php
                                $text_error = 'badge_name.' . $lang['code'] . '.badge_name';
                            @endphp
                            <div class="mb-3 col-md-6">
                                <label class="col-form-label ">
                                    <span class="required">Badge Name For {{ $lang['language'] }} <span
                                            class="text-danger">*</span></span>
                                </label>
                                <input type="text" class="form-control @error($text_error) is-invalid @enderror" id="badge_name"
                                    name="badge_name[{{ $lang['code'] }}][badge_name]" value="@if(!empty($array[$lang['code']]['badge_name'])){{ $array[$lang['code']]['badge_name'] }} @endif" placeholder="Enter Badge Name">

                            </div>
                        @endforeach
                   

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="value">Badge Required Minute<span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="badge_required_minute" name="badge_required_minute"
                            type="text" placeholder="Enter Badge Required Minute" aria-label="Badge Required Minute" value="{{ $data['badge_required_minute']}}">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="value">Badge Required Number Refer<span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="badge_required_number_refer" name="badge_required_number_refer"
                            type="text" placeholder="Enter Badge Required Number Refer"
                            aria-label="Badge Required Number Refer" value="{{ $data['badge_required_number_refer']}}">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label" for="value">Badge Required Challenge <span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="badge_required_challenge" name="badge_required_challenge"
                            type="text" placeholder="Enter Badge Required Challenge"
                            aria-label="Badge Required Challenge" value="{{ $data['badge_required_challenge']}}">
                    </div>

                    <div class="mb-3 col-md-9">
                        <label class="form-label" for="value">Badge Image  <span class="text-danger"> 800px X 600px (Accept:png,jpg,jpeg)</span></label>
                        <input class="form-control" id="badge_image" name="badge_image" type="file" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label" for="badge_image"><br><br></label>
                        <img src='{{ static_asset('badge_image') }}/{{ $data->badge_image }}'
                            class="img-thumbnail brand-image img-circle elevation-3" height="35"
                            width="35" />
                    </div>

                    
                </div>

                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="badgeSubmit"><i
                        class="fa fa-spinner fa-spin d-none icon"></i> Update</button>

                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal" id="is_close"
                    onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
