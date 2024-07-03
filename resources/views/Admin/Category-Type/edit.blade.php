<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Update Category Type</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" onclick="return close_or_clear();"></button>
        </div>
        <div class="modal-body" id="myModal">
            <form class="form-bookmark" method="post" action="{{ route('category-type.update',$data->id) }}" id="category-type-edit-form">
                @csrf
                @method('put')
                <div class="row g-2">

                    <?php $language = get_language(); ?>

                    <?php $categories_list = main_categories_list(); ?>
                        <div class="col-md-6">
                            <label class="form-label">Select Main Categories <span class="text-danger">*</span></label>
                            <select name="main_category_id[]"  id="main_category_id"
                                 class="form-select custom_select2 main_category_id" multiple>
                                @foreach ($categories_list as $categoty)
                                        @php
                                            $title_array = json_decode($categoty['category_name'], true);
                                            if (!empty($title_array['en']['category_name'])) {$category_name = $title_array['en']['category_name'];} else { $category_name = "No Data Found";}
                                         @endphp
                                 <option value="{{$categoty['id'] }}" @if($data->main_category_id != null) @if(in_array($categoty['id'],json_decode($data->main_category_id))) selected @endif @endif> {{ $category_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <?php $categories_list = get_sub_categories(); ?>
                        <div class="col-md-6" id="category1">
                            <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                            <select name="category_id"  id="category_id"
                                 class="form-select categoryData">
                                @foreach ($categories_list as $categoty)
                                        @php
                                            $title_array = json_decode($categoty['category_name'], true);
                                            if (!empty($title_array['en']['category_name'])) {$category_name = $title_array['en']['category_name'];} else { $category_name = "No Data Found";}
                                         @endphp
                                 <option value="{{$categoty['id'] }}" @if($data->category_id == $categoty->id) selected @endif> {{ $category_name }}</option>
                                @endforeach
                            </select>
                        </div>


                    @foreach ($language as $key => $lang)
                    @php
                        $text_error = 'Type.' . $lang['code'] . '.Type';
                        $array = json_decode($data['type'], true);
                    @endphp
                    <div class="col-md-6">
                        <label class="col-form-label ">
                            <span class="required">{{ $lang['language'] }} Type Name <span class="text-danger">*</span></span>
                        </label>
                            <input type="text" name="type[{{ $lang['code'] }}][type]" id="category-type" class="form-control" placeholder="Enter Type" @error('key') is-invalid @enderror value="@if (!empty($array[$lang['code']]['type'])){{ $array[$lang['code']]['type'] }} @endif">
                    </div>


                @endforeach


                </div>
                <button class="btn btn-primary btn-sm btn-custom" type="submit" id="couponSubmit"><i class="fa fa-spinner fa-spin d-none icon"></i> Update</button>
                <button class="btn btn-secondary btn-sm"  type="button" data-bs-dismiss="modal"
                    id="is_close" onclick="return close_or_clear();">Close</button>


            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        $('.main_category_id').on('change', function() {
               var category_id = $('.main_category_id').val();
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('sub.category.list') }}",
                data: {
                    category_id: category_id
                },
                success: function(response) {
                    $('.categoryData').empty();
                        jQuery.each(response, function(index, item) {
                        $('.categoryData').append(' <option value='+ item['id'] + ' >'+ item['category_name_en'] +'</option>  ')
                    });
                }
                });
            });




            $('.category_id').on('change', function() {
                var category = $('.category_id').val();
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('get-type') }}",
                data: {
                    category: category
                },
                success: function(response) {
                    $('.typeData').empty();
                        jQuery.each(response, function(index, item) {
                        $('.typeData').append(' <option value='+ item['id'] + ' >'+ item['type_name_en'] +'</option>  ')
                    });
                }
                });
            });

    });

    $('.custom_select2').select2({
          // dropdownParent: $('#createsubscriptionmodel')
    });






   </script>

