<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Badge</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('badge.store') }}" id="badge-frm">
                @csrf
                <?php $language = get_language(); ?>
                <div class="row">

                           

                          
                                @foreach ($language as $key => $lang)
                                    @php
                                        $text_error = 'badge_name.' . $lang['code'] . '.badge_name';
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label class="col-form-label ">
                                            <span class="required">Badge Name For {{ $lang['language'] }}<span class="text-danger">*</span></span>
                                        </label>
                                        <input type="text" class="form-control @error($text_error) is-invalid @enderror" id="badge_name"
                                            name="badge_name[{{ $lang['code'] }}][badge_name]"  placeholder="Enter Badge Name">
                                    </div>
                                @endforeach
                            



                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="value">Badge Required Minute<span class="text-danger">*</span></label>
                                <input class="form-control" id="badge_required_minute" name="badge_required_minute" type="text"
                                    placeholder="Enter Badge Required Minute" aria-label="Badge Required Minute">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="value">Badge Required Number Refer<span class="text-danger">*</span></label>
                                <input class="form-control" id="badge_required_number_refer" name="badge_required_number_refer" type="text"
                                    placeholder="Enter Badge Required Number Refer" aria-label="Badge Required Number Refer">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="value">Badge Required Challenge <span class="text-danger">*</span></label>
                                <input class="form-control" id="badge_required_challenge" name="badge_required_challenge" type="text"
                                    placeholder="Enter Badge Required Challenge" aria-label="Badge Required Challenge">
                            </div>

                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="value">Badge Image  <span class="text-danger"> 800px X 600px (Accept:png,jpg,jpeg)</span></label>
                                <input class="form-control" id="badge_image" name="badge_image" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                            

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="badgeSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
