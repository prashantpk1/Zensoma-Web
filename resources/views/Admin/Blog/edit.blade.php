<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Update Resource</h5>
             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"  onclick="return close_or_clear();"></button>
         </div>
         <div class="modal-body" id="myModal">
             <form class="form-bookmark needs-validation" method="post" action="{{ route('blog.update', $data->id) }}"
                 enctype="multipart/form-data" id="blog-edit-form">
                 <?php $language = get_language(); ?>
                 @csrf
                 @method('PUT')
                 <div class="row g-2">
                     <div class="mb-3 col-md-12 mt-0">
                         <div class="row">
                             <div class="col-sm-4">
                                <label class="form-label">Key <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control @error('key') is-invalid @enderror"
                                     id="key" name="key" placeholder="Add Unique key"
                                     value="{{ $data->key }}">
                            </div>
                            <div class="col-sm-4">
                                 <label class="form-label">Resource Image - <span class="text-danger"> 1000px X 700px</span> </label>
                                 <input type="file" class="form-control @error('blog_image') is-invalid @enderror"
                                 id="blog_image" name="blog_image" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="col-sm-1">
                                    <label class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                 <img src='{{ static_asset('blog_image') }}/{{ $data->image }}'
                                     class="img-thumbnail brand-image img-circle elevation-3" height="50"
                                     width="50" />

                             </div>
                             <?php $categories_list = get_categories(); ?>
                             <div class="col-md-3" id="category">
                                 <label class="form-label">Select Categories <span class="text-danger">*</span></label>
                                 <select name="category_id" aria-label="Select a Categories" id="category_id"
                                      class="form-select">
                                      <option value="">Select Category </option>
                                     @foreach ($categories_list as $categoty)
                                             @php
                                                     $title_array = json_decode($categoty['category_name'], true);
                                                     if (!empty($title_array['en']['category_name'])) {$data_blog_title = $title_array['en']['category_name'];} else { $data_blog_title = "No Data Found";}
                                             @endphp
                                         <option value="{{ $categoty['id']}}" @if($categoty['id'] == $data->category_id) selected="" @endif>{{ $data_blog_title }}</option>
                                     @endforeach
                                 </select>
                             </div>


                         </div>
                     </div>


                     @foreach ($language as $key => $lang)
                         <input type="hidden" name="language[{{ $key }}][language]"
                             value="{{ $lang['code'] }}">
                         <div class="col-12" id="accordion">
                             <hr class="dashed">
                             <div class="form-label"> Resource Content For {{ $lang['language'] }}</div>
                             <hr class="dashed">
                         </div>
                         @php
                             $title_text_error = 'blog_title.' . $lang['code'] . '.blog_title';
                         @endphp
                         <?php $title_array = json_decode($data['title'], true); ?>

                         <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">Resource Title <span class="text-danger">*</span></span>
                            </label>
                             <input type="text" class="form-control @error($title_text_error) is-invalid @enderror"
                                 id="blog_title" name="blog_title[{{ $lang['code'] }}][blog_title]"
                                 placeholder="Enter Resource Title"
                                 value="@if (!empty($title_array[$lang['code']]['blog_title'])) {{ $title_array[$lang['code']]['blog_title'] }} @endif">

                         </div>
                         @php
                             $blog_sub_title_text_error = 'blog_sub_title.' . $lang['code'] . '.blog_sub_title';
                         @endphp
                         <?php $sub_title_array = json_decode($data['sub_title'], true); ?>
                         <div class="col-md-6">
                            <label class="col-form-label ">
                                <span class="required">Resource Sub Title <span class="text-danger">*</span></span>
                            </label>
                             <input type="text"
                                 class="form-control @error($blog_sub_title_text_error) is-invalid @enderror"
                                 id="blog_sub_title" name="blog_sub_title[{{ $lang['code'] }}][blog_sub_title]"
                                 placeholder="Enter Resource Sub Title for {{ $lang['language'] }}"
                                 value="@if (!empty($sub_title_array[$lang['code']]['blog_sub_title'])) {{ $sub_title_array[$lang['code']]['blog_sub_title'] }} @endif">
                         </div>
                         @php
                             $description_text_error = 'description.' . $lang['code'] . '.description';
                         @endphp
                         <?php $description_array = json_decode($data['description'], true); ?>
                         <div class="col-md-12">
                            <label class="col-form-label ">
                                <span class="required">Description <span class="text-danger">*</span></span>
                            </label>
                             <textarea class="form-control @error($description_text_error) is-invalid @enderror ckeditoredit"
                                 name="description[{{ $lang['code'] }}][description]" placeholder="Enter Description for {{ $lang['language'] }}">@if (!empty($description_array[$lang['code']]['description'])){{ $description_array[$lang['code']]['description'] }}@endif</textarea>
                             </textarea>

                         </div>
                     @endforeach


                 </div>
                 <button class="btn btn-primary btn-sm btn-custom" type="submit" id="blogSubmit"> <i class="fa fa-spinner fa-spin d-none icon"></i>  Update</button>
                 <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                     id="is_close"  onclick="return close_or_clear();">Close</button>
             </form>
         </div>
     </div>
 </div>



 <script type="text/javascript">
     $(document).ready(function() {
         CKEDITOR.replaceAll('ckeditoredit');
     });
 </script>
