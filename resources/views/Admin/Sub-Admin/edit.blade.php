<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Sub Admin</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark needs-validation" method="post"
                action="{{ route('subadmin.update', $data->id) }}" enctype="multipart/form-data" id="subadmin-edit-form">
                @csrf
                @method('PUT')
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="role_name">Role Name <span class="text-danger">*</span></label>
                                <input class="form-control @error('role_name') is-invalid @enderror" id="role_name"
                                    name="role_name" type="text" placeholder="Enter Role Name"
                                    aria-label="Role Name" value="{{ $data->role_name }}">
                            </div>
                            {{-- <div class="col-sm-6">
                                <label class="form-label" for="first_name">First Name</label>
                                <input class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                    name="first_name" type="text" placeholder="Enter First Name"
                                    aria-label="First Name" value="{{ $data->first_name }}">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                    name="last_name" type="text" placeholder="Enter Last Name"
                                    value="{{ $data->last_name }}">
                            </div> --}}

                            <div class="col-sm-6">
                                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" type="text" placeholder="Enter Name"
                                    aria-label="Name" value="{{ $data->name }}">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" type="text" placeholder="Enter Email"
                                    aria-label="Email" value="{{ $data->email }}">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                                <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" type="text" placeholder="Enter Phone" value="{{ $data->phone }}">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" aria-label="Select a Gender"
                                    data-placeholder="Select a Gender..." class="form-select">
                                    <option value="Male"
                                        @if ($data->gender == 'Male') selected = "selected" @endif>
                                        Male</option>
                                    <option value="Female"
                                        @if ($data->gender == 'Female') selected = "selected" @endif>
                                        Female</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="profile_image">Profile Image <span class="text-danger"> 200px x 200px  (Accept:png,jpg,jpeg)</span> </label>
                                <input class="form-control" id="profile_image" type="file" name="profile_image"
                                    accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label" for="profile_image"></label><br>
                                <img src="@if(!empty($data->profile_image)){{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }}@endif" class=""
                                    style="height:30px">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="admin_commission">Admin Commission(%) <span class="text-danger">*</span></label>
                                <input class="form-control @error('admin_commission') is-invalid @enderror" id="admin_commission"
                                    name="admin_commission" type="text" placeholder="Enter Admin Commission Per"
                                    aria-label="Admin Commission Per" value="{{ $data->admin_commission }}">
                            </div>



                        </div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="customerSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
