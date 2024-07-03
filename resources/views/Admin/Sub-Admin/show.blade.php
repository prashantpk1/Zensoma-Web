<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sud Admin Detail</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="flex-space flex-wrap align-items-center"><img class="b-r-8 img-100"
                        src="@if(!empty($data->profile_image)){{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" alt="profile">
                    <h4><label> Name : </label> {{ $data->name }}</h4>
                </div>
                    <div class="list-persons">
                        <div class="profile-mail">
                            <div class="email-general">
                                <ul>
                                    <li>Email : <span class="font-primary first_name_0"> {{ $data->email }}</span></li>
                                    <li>Phone : <span class="font-primary"> {{ $data->phone }}</span></li>
                                    <li>Gender :<span class="font-primary"> <span class="birth_day_0">{{ $data->gender }}</span>
                                                </li>
                                    <li>Joining Date :<span class="font-primary personality_0">{{ $data->created_at }}</span></li>
                                    <li>Referral Code :<span class="font-primary city_0">{{ $data->referral_code }}</span></li>
                                    <li>Status :<span class="font-primary mobile_num_0">
                                        @if ($data->is_approved == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($data->is_approved == 2)
                                        <span class="badge bg-danger">Reject</span>
                                    @else
                                        <span class="badge bg-info">Pendding</span>
                                    @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

