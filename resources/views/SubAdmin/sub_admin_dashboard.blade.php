@extends('Admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h4>Sub Admin Dashboard</h4>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">
                            <svg class="stroke-icon">
                                <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Sub Admin Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row widget-grid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div class="widget-round secondary">
                                    <div class="bg-round">
                                        <i class="fa fa-user"></i>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4> {{ $total['total_day'] }} </h4><span class="f-light">Total Day
                                        :</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div class="widget-round success">
                                    <div class="bg-round">
                                        <i class="fa fa-user"></i>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4> {{ $total['number_of_slot'] }}</h4><span class="f-light">Total Slot
                                        :</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div class="widget-round warning">
                                    <div class="bg-round">
                                        <i class="fa fa-list"></i>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4> {{ $total['total_active_content'] }}</h4><span class="f-light">Total Active Session
                                        :</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-3">
                    <div class="card widget-1">
                        <div class="card-body">
                            <div class="widget-content">
                                <div class="widget-round info">
                                    <div class="bg-round">
                                        <i class="fa fa-quote-left"></i>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4> {{ $total['total_booking'] }}</h4><span class="f-light">Total Booking :</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-12 box-col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Booking Base on Month</h5>
                        </div>
                        <div class="card-body chart-block">
                            <canvas id="myBarGraph1"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-md-6 appointment-sec box-col-6">
                    <div class="appointment">
                        <div class="card">
                            <div class="card-header card-no-border">
                                <div class="header-top">
                                    <h5 class="m-0">Recent Booking</h5>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="appointment-table table-responsive">
                                    <table class="table table-bordernone">
                                        <tbody>
                                            @foreach ($total['booking'] as $booking)
                                                <tr>
                                                    <td>
                                                        @if ($booking->user_data->profile_image == null && $booking->user_data->profile_image == '')
                                                            <img class="b-r-8 img-40"
                                                                src="{{ static_asset('admin/assets/images/user/user.png') }}"
                                                                alt="Generic placeholder image">
                                                        @else
                                                            <img class="img-fluid img-40 rounded-circle"
                                                                src="{{ static_asset('profile_image/' . $booking->user_data->profile_image) }}"
                                                                alt="user">
                                                        @endif
                                                    </td>
                                                    <td class="img-content-box"><a class="d-block f-w-500"
                                                            href="#">{{ $booking->user_data->name }} </a>
                                                            <span
                                                            class="f-light">{{ $booking->date }} ({{ $booking->start_time }} - {{ $booking->end_time }})</span>
                                                        </td>

                                                    <td class="text-end">
                                                        <p class="m-0 font-success">{{ $booking['status'] }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Container-fluid Ends-->
@endsection


@section('script')
    <!-- Plugins JS Ends-->

    <script>
         //for bar chart start
         var barchart = {!! json_encode($total['barchart_count']) !!};

         var barData = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                "November", "December"
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(115, 102 ,255, 0.4)",
                strokeColor: CubaAdminConfig.primary,
                highlightFill: "rgba(115, 102 ,255, 0.6)",
                highlightStroke: CubaAdminConfig.primary,
                data: barchart,
            }, ],
        };
        var barOptions = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,0.1)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            barShowStroke: true,
            barStrokeWidth: 2,
            barValueSpacing: 5,
            barDatasetSpacing: 1,
        };
        var barCtx = document.getElementById("myBarGraph1").getContext("2d");
        var myBarChart = new Chart(barCtx).Bar(barData, barOptions);



        //for bar chart end


    </script>
@endsection


