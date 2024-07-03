<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Resource Detail</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="blog-single">
                      <div class="blog-box blog-details"><img class="img-fluid w-100" src="{{ static_asset('blog_image') }}/{{ $data->image }}" alt="blog-main">
                        <div class="blog-details">
                          <ul class="blog-social">
                            <li>{{ $data->created_at }}</li>
                            <li><i class="icofont icofont-user"></i>{{ $data->key }} </li>
                          </ul>
                          <h4>
                            <?php $language = get_language(); ?>
                            @foreach ($language as $key => $lang)

                            <?php $title_array = json_decode($data['title'], true); ?>
                            @if(!empty($title_array[$lang['code']]['blog_title']))
                            <label>Resource Title {{ $lang['code'] }} : </label>
                              {{ $title_array[$lang['code']]['blog_title'] }}
                              <br>
                            @endif

                              <?php $title_sub_array = json_decode($data['sub_title'], true); ?>
                              {{-- @if($title_sub_array[$lang['code']]['blog_sub_title']) --}}
                              @if(!empty($title_sub_array[$lang['code']]['blog_sub_title']))
                              <label>Resource Sub Title {{ $lang['code'] }} : </label>
                              {{ $title_sub_array[$lang['code']]['blog_sub_title'] }}
                              <br>
                              @endif


                              <?php $description = json_decode($data['description'], true); ?>
                              {{-- @if($description[$lang['code']]['description']) --}}
                              @if(!empty($description[$lang['code']]['description']))
                              <div class="single-blog-content-top"><?php $des = $description[$lang['code']]['description']; ?>    {!! $des  !!} </div>
                              <br>
                              @endif


                            @endforeach

                        </div>
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal"
                        id="is_close">Close</button>
                      </div>
                     </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
