<div class="modal-dialog modal-lg" role="document" style="overflow-y: scroll; max-height:85%;  margin-top: 60px; margin-bottom:60px;" >
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Customer List</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="container-fluid basic_table">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table" class="buddy-network-detail" id="buddy-network-detail">
                                        <thead>
                                            <tr class="border-bottom-primary">
                                                <th scope="col">Id</th>
                                                <th scope="col">Customer Detail</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Joining Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php  $i = 1; @endphp
                                            @if(count($data) != 0)
                                            @foreach ($data as $key => $user)
                                                <tr class="border-bottom-primary">
                                                    <th scope="row">{{ $i }}</th>
                                                    <td>
                                                        <div class="media">
                                                            @if ($user->user_data->profile_image != null && $user->user_data->profile_image != '')
                                                                <img class="b-r-8 img-40"
                                                                    src="{{ static_asset('profile_image/' . $user->user_data->profile_image) }}"
                                                                    alt="Generic placeholder image">
                                                            @else
                                                                <img class="b-r-8 img-40"
                                                                    src="{{ static_asset('admin/assets/images/user/user.png') }}"
                                                                    alt="Generic placeholder image">
                                                            @endif
                                                            <div class="media-body">
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <h6 class="mt-0">&nbsp;&nbsp;
                                                                            {{ $user->user_data->first_name }}
                                                                            {{ $user->user_data->last_name }}</span>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                                <p>&nbsp;&nbsp; {{ $user->user_data->email }}</p>

                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>  <p>&nbsp;&nbsp; {{ $user->user_data->phone }}</p></td>

                                                    <td>{{ date('Y-M-d h:i A', strtotime($user->user_data->created_at)) }}
                                                    </td>
                                                </tr>
                                                @php $i++; @endphp
                                            @endforeach
                                            @else
                                            <tr class="border-bottom-primary">
                                                <td><p> No Buddy Found </p></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    {{-- {!! $data->links() !!} --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
