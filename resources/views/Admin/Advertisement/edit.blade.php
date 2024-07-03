<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Update Advertisement</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <form class="form-bookmark needs-validation" method="post" action="{{ route('advertisement.update', $data->id) }}"
                 enctype="multipart/form-data" id="advertisement-edit-form">
                 @csrf
                 @method('PUT')
                 <div class="row g-2">
                     <div class="mb-3 col-md-12 mt-0">
                         <div class="row">

                             <div class="col-sm-9">
                                <label class="form-label" for="advertisement_image">Advertisement Image <span class="text-danger"> 800px X 600px (Accept:png,jpg,jpeg)</span></label>
                                 <input type="file" class="form-control @error('advertisement_image') is-invalid @enderror"
                                     id="advertisement_image" name="advertisement_image" accept=".png, .jpg, .jpeg">
                            </div>

                            <div class="col-sm-3">
                                <label class="form-label" for="advertisement_image"><br><br></label>
                                 <img src='{{ static_asset('advertisement_image') }}/{{ $data->advertisement_image }}'
                                     class="img-thumbnail brand-image img-circle elevation-3" height="70"
                                     width="70" />

                             </div>
                        </div>
                     </div>

                 </div>
                 <button class="btn btn-primary btn-sm btn-custom" type="submit" id="advertisementSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                 <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                     id="is_close">Close</button>
             </form>
         </div>
     </div>
 </div>



 <script type="text/javascript">
     $(document).ready(function() {
         CKEDITOR.replaceAll('ckeditoredit');
     });
 </script>
