<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Send Notificataion</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body"  id="myModal">
            <form class="form-bookmark needs-validation" method="post" action="{{ route('notification.store') }}"
                enctype="multipart/form-data" id="notification-frm">
                @csrf
                <?php $language = get_language(); ?>
                <?php $categories = categories_list(); ?>
                <div class="row g-2">
                    <div class="col-md-12 mt-0">
                        <div class="row g-3">


                            <div class="col-md-12">
                                <label class="form-label">
                                    <span class="required">Title  <span class="text-danger">*</span></span>
                                </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter Title" @error('title') is-invalid @enderror>
                            </div>


                            <div class="col-sm-6">
                                <label class="form-label">Notification Type  <span class="text-danger">*</span></label>
                                <select name="notification_type" aria-label="Select a Notification Type" id="notification_type"
                                    data-placeholder="Select a Notification Type..." class="form-select">
                                    <option value="">Select Notification Type</option>
                                    <option value="email">Email</option>
                                    <option value="push_notification">Push Notification</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>


                            <div class="col-sm-6">
                                <label class="form-label">User Type  <span class="text-danger">*</span></label>
                                <select name="user_type" aria-label="Select a User Type"
                                    data-placeholder="Select a User Type..." class="form-select">
                                    <option value="">Select User Type</option>
                                    <option value="0">Customer</option>
                                    <option value="1">Sub Admin</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>



                            <div class="col-md-12" id="id">
                                <label class="col-form-label ">
                                    <span class="required">Content (Message)  <span class="text-danger">*</span></span>
                                </label>
                                <textarea type="text" class="form-control @error('content') is-invalid @enderror" name="content"
                                    id="content"></textarea>
                            </div>


                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="notificationSubmit"> <i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
