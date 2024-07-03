<div class="modal-dialog modal-lg" role="document">
    <?php $categories = get_categories(); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Slots</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="form-bookmark needs-validation" method="post" action="{{ route('calendar.store') }}"
                enctype="multipart/form-data" id="slot-frm">
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-12 mt-0">
                        <div class="row">


                            <div class="col-sm-6">
                                <label class="col-form-label ">
                                    <span class="required">Select Date <span class="text-danger">*</span></span>
                                </label>
                                <div class="input-group flatpicker-calender">
                                    <input class="form-control flatpickr-input active" id="multiple-date-custom"  name="date" type="text" readonly="readonly">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label ">
                                    <span class="required">Title (Note) <span class="text-danger">*</span></span>
                                </label>
                                <input class="form-control" id="title" type="text" name="title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" aria-label="Select a Category"
                                    data-placeholder="Select a Category..." class="form-select">
                                    <option value="" selected="">Select Category..</option>
                                    @foreach ($categories as $key => $cat)
                                        @php
                                            $title_array = json_decode($cat['category_name'], true);
                                            if (!empty($title_array['en']['category_name'])) {
                                                $cat_name = $title_array['en']['category_name'];
                                            } else {
                                                $cat_name = 'No Data Found';
                                            }

                                        @endphp
                                        <option value="{{ $cat['id'] }}">{{ $cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>




                            <div class="col-md-6">
                                <label class="col-form-label">Select Time Duration <span class="text-danger">*</span></label>
                                <select name="slot_duration" aria-label="Select a Duration" id="duration"
                                    data-placeholder="Select a Duration..." class="form-select">
                                    <option value="30">30 Minute</option>
                                    <option value="60">60 Minute</option>
                                    <option value="90">90 Minute</option>
                                    <option value="120">120 Minute</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label">
                                    <span class="required">Start Time <span class="text-danger">*</span></span>
                                </label>
                                <input class="form-control" id="time-picker" type="time" name="start_time">
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label ">
                                    <span class="required">End Time <span class="text-danger">*</span></span>
                                </label>
                                <input class="form-control" id="time-picker" type="time" name="end_time">
                            </div>

                            <div class="col-sm-6">
                                <label>Price Type <span class="text-danger">*</span></label>
                                <div class="m-checkbox-inline">
                                    <label for="edo-ani">
                                        <input class="radio_animated" id="edo-ani" type="radio" name="price_type" value="price_per_slot"
                                            checked="">Price Per Slot
                                    </label>
                                    <label for="edo-ani1">
                                        <input class="radio_animated" id="edo-ani1" type="radio" name="price_type" value="total_price">Total
                                        Price
                                    </label>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <label class="col-form-label ">
                                    <span class="required">Price (Per Slot) <span class="text-danger">*</span></span>
                                </label>
                                <input class="form-control" id="price" type="number" name="price">
                            </div>



                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="slotSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Submit</button>
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                    id="is_close">Close</button>
            </form>
        </div>
    </div>
</div>
