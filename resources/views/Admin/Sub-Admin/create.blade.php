<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Sub Admin</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark needs-validation" method="post"
                action="{{ route('subadmin.store') }}" enctype="multipart/form-data" id="subadmin-frm">
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">

                            <div class="col-sm-6">
                                <label class="form-label" for="role_name">Role Name <span class="text-danger">*</span></label>
                                <input class="form-control @error('role_name') is-invalid @enderror" id="role_name"
                                    name="role_name" type="text" placeholder="Enter Role Name"
                                    aria-label="Role Name">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" type="text" placeholder="Enter Name"
                                    aria-label="Name">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" type="text" placeholder="Enter Email" autocomplete="off">
                            </div>


                            <div class="col-sm-6">
                                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                                <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" type="text" placeholder="Enter Phone">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    name="password" type="password" placeholder="Enter Password"  autocomplete="off">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" aria-label="Select a Gender"
                                    data-placeholder="Select a Gender..." class="form-select">
                                    <option value="">Select a Gender</option>
                                    <option value="Male"> Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="profile_image">Profile Image - <span class="text-danger"> 200px x 200px  (Accept:png,jpg,jpeg)</span> </label>
                                <input class="form-control" id="profile_image" type="file" name="profile_image"
                                    accept=".png, .jpg, .jpeg">
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="admin_commission">Admin Commission(%) <span class="text-danger">*</span></label>
                                <input class="form-control @error('admin_commission') is-invalid @enderror" id="admin_commission"
                                    name="admin_commission" type="text" placeholder="Enter Admin Commission Per"
                                    aria-label="Admin Commission Per">
                            </div>

                        </div>
                    </div>

                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="subadminSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
