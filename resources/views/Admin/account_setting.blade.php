@extends('Admin.layouts.app')
@section('content')

<div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-6">
          <h4>Account Setting</h4>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">
                <svg class="stroke-icon">
                  <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                </svg></a></li>
            <li class="breadcrumb-item">Acoount Setting</li>
            <li class="breadcrumb-item active">Account Settings</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12">
        <div class="card height-equal">
          <div class="card-header">
            <h4>Edit Profile</h4>
           </div>
          <div class="card-body custom-input">
             <form class="row g-3" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-submit">
                @csrf
                @method('patch')

                <div class="col-6">
                    <label class="form-label" for="name">Name  <span class="text-danger">*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" placeholder="Name" aria-label="Name" name="name" value="{{ Auth::user()->name }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

              <div class="col-4">
                <label class="form-label" for="profile_image">Profile Image - <span class="text-danger">200px * 200px</span> <span class="text-danger">*</span></label>
                <input class="form-control" id="profile_image" type="file" name="profile_image" accept=".png, .jpg, .jpeg">
              </div>
              <div class="col-2">
                <label class="form-label" for="profile_image">Current Image</label><br>
                <img src="{{ static_asset('profile_image/' . Auth::user()->profile_image) }}" class="" style="height:30px">
              </div>

              <div class="col-6">
                <label class="form-label" for="email">Email Address  <span class="text-danger">*</span></label>
                <input class="form-control  @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Enter Email ID" value="{{ Auth::user()->email }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
             </div>

              <div class="col-6">
                <label class="form-label" for="phone">Phone  <span class="text-danger">*</span></label>
                <input class="form-control  @error('phone') is-invalid @enderror" name="phone" id="phone" type="text" placeholder="Enter Phone" value="{{ Auth::user()->phone }}">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
               @enderror
              </div>

              <div class="col-6">
                <label class="form-label">Gender</label>
                <select name="gender" aria-label="Select a Gender"
                    data-placeholder="Select a Gender..."
                    class="form-select">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-12">
                {{-- <input type="submit" class="btn btn-primary" value="Submit" id="profileSubmit"> --}}
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="profileSubmit"> <i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-xl-12">
        <div class="card height-equal">
          <div class="card-header">
            <h4>Change Password</h4>
           </div>
          <div class="card-body custom-input">
             <form class="row g-3" method="post" action="{{ route('store.change.password') }}" id="change-password-submit">
                @csrf

              <div class="col-8">
                <label class="form-label" for="current_password">Current Password  <span class="text-danger">*</span></label>
                <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" type="password" placeholder="Current Password" aria-label="current_password" name="current_password">
                @error('current_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>


              <div class="col-8">
                <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" placeholder="New Password" aria-label="password" name="password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>



              <div class="col-8">
                <label class="form-label" for="password_confirmation">Password Confirmation  <span class="text-danger">*</span></label>
                <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" placeholder="Password Confirmation" aria-label="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>




            <div class="col-12">
                {{-- <input type="submit" class="btn btn-primary btn-custom" value="Submit" id="change-passwordSubmit"> --}}
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="change-passwordSubmit"> <i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>

                <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>




@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('submit', '#profile-submit', function(e) {
                e.preventDefault();
                var frm = this;
                var btn = $('#profileSubmit');
                var url = $(this).attr('action');
                var formData = new FormData(frm);

                formData.append("_method", 'PATCH');
                jQuery('.btn-custom').addClass('disabled');
                jQuery('.icon').removeClass('d-none');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        show_toster(response.success)
                        frm.reset();
                        location.reload();
                        jQuery('.btn-custom').removeClass('disabled');
                        jQuery('.icon').addClass('d-none');
                    },
                    error: function(xhr) {
                        // $('#send').button('reset');
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            toastr.error(value);

                        });
                    },
                });

            });



            $(document).on('submit', '#change-password-submit', function(e) {
                e.preventDefault();
                var frm = this;
                var btn = $('#change-passwordSubmit');
                var url = $(this).attr('action');
                var formData = new FormData(frm);

                // formData.append("_method", 'PATCH');

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        show_toster(response.success)
                        table.draw();
                        frm.reset();
                    },
                    error: function(xhr) {
                        // $('#send').button('reset');
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            var ele = "#" + key;
                            toastr.error(value);
                        });
                    },
                });

            });


        });
    </script>
@endsection

