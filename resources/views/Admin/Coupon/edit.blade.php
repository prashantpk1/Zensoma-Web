<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Coupon</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            {{-- <form class="form-bookmark"> --}}
            <form class="form-bookmark" method="post" action="{{ route('coupon.update',$data->id) }}" id="coupon-edit-form">
                @csrf
                @method('put')
                <div class="row g-2">
                    <div class="mb-3 col-md-12">
                        <label class="form-label" for="coupon_code">Coupon Code <span class="text-danger">*</span></label>
                        <input class="form-control" id="coupon_code" name="coupon_code" type="text"
                            placeholder="Enter coupon Code" aria-label="coupon Code" value="{{ $data->code }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="coupon_code">Coupon Type <span class="text-danger">*</span></label>
                            <select name="coupon_type" id="coupon_type" aria-label="Select a Coupon Type"
                                    data-placeholder="Select a Coupon Type..."
                                    class="form-select">
                                    <option value="fixed" @if($data->type == "fixed") selected="" @endif>Fixed</option>
                                    <option value="percent" @if($data->type == "percent") selected="" @endif>Percentage %</option>
                            </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="value">Coupon Value <span class="text-danger">*</span></label>
                        <input class="form-control" id="coupon_value" name="coupon_value" type="text"
                            placeholder="Enter value" aria-label="value" value="{{ $data->value }}">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label" for="value">Coupon Expired Date <span class="text-danger">*</span></label>
                        <input class="form-control flatpickr-input" id="expired_date" name="expired_date" type="date" aria-label="value" value="{{ $data->expired_date }}" min="<?= date('Y-m-d') ?>">
                    </div>



                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="couponSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i>  Update</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>
            </form>
        </div>
    </div>
</div>
