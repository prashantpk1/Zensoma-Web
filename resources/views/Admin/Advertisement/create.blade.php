<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Add Advertisement Image</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark" method="post" action="{{ route('advertisement.store') }}" id="advertisement-frm">
                @csrf
                <div class="row g-2">

                    <div class="col-sm-12">
                        <label class="form-label" for="advertisement_image">Advertisement Image <span class="text-danger"> 800px X 600px (Accept:png,jpg,jpeg)</span></label>
                        <input class="form-control" id="advertisement_image" type="file" name="advertisement_image"
                            accept=".png, .jpg, .jpeg">
                    </div>
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="advertisementSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>


