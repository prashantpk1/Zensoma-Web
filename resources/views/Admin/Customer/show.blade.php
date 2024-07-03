@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">

                    <h4><a class="text-primary" href="{{ route('customer.index') }}" data-bs-toggle="card-remove"><i class="icofont icofont-arrow-left" style="font-size: 1.5em;"></i>
                    </a> Customer Detail</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">

                        {{-- <li class="breadcrumb-item"><button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#createcustomermodel"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New</button></li> --}}


                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title mb-0">Customer Detail</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a></div>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-2">
                                    <div class="profile-title">
                                        <div class="media">
                                            <img class="img-70 rounded-circle" alt=""
                                                src="@if (!empty($data->profile_image)) {{ static_asset('profile_image/' . $data->profile_image) }}@else{{ static_asset('/admin/assets/images/user/user.png') }} @endif">
                                            <div class="media-body">
                                                <h5 class="mb-1">{{ $data->name }}</h5>
                                                <p>Customer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="list-persons">
                                    <div class="profile-mail">
                                        <div class="email-general">
                                            <ul>
                                                <li>Email : <span class="font-primary first_name_0">
                                                        {{ $data->email }}</span></li>
                                                <li>Phone : <span class="font-primary"> {{ $data->phone }}</span></li>
                                                <li>Gender :<span class="font-primary"> <span class="birth_day_0">
                                                            @if ($data->gender)
                                                                {{ $data->gender }}
                                                            @else
                                                                Gender Not Added
                                                            @endif
                                                        </span>
                                                </li>
                                                <li>Referral Code :<span
                                                        class="font-primary city_0">{{ $data->referral_code }}</span></li>
                                                <li>Joining Date :<span
                                                        class="font-primary personality_0">{{ $data->created_at }}</span>
                                                </li>
                                                <li>Device Type :<span class="font-primary personality_0">
                                                        @if ($data->device_type)
                                                            {{ $data->device_type }}
                                                        @else
                                                            Device Type Not Added
                                                        @endif
                                                    </span></li>
                                                <li>Customer Status :<span class="font-primary mobile_num_0">
                                                        @if ($data->is_approved == 1)
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif($data->is_approved == 2)
                                                            <span class="badge bg-danger">Reject</span>
                                                        @else
                                                            <span class="badge bg-info">Pendding</span>
                                                        @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Predefined Question Answer By Customer</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="table-responsive add-project">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($data_predefined_answer)
                                        <?php $jsonArray = json_decode($data_predefined_answer->answers);
                                        $i = 1;
                                        ?>
                                        {{-- @dd($jsonArray); --}}
                                        @foreach ($jsonArray as $data_new)
                                            <?php $question = get_question($data_new->question_id); ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a class="text-inherit" href="#">{{ $question->question }} </a>
                                                </td>
                                                @if ($data_new->option_type == 'range')
                                                    <td> {{ $data_new->value }}</td>
                                                @else
                                                    <td>
                                                        <?php $option = get_option($data_new->value); ?>{{ $option }}</td>
                                                @endif
                                            </tr>
                                            <?php  $i++;  ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>Predefined Question Answer No Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->





    </div>
@endsection
