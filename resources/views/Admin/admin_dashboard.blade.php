@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>Admin Dashboard</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Admin Dashboard</li>
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
                                        <h4> {{ $total['total_customer'] }}</h4><span class="f-light">Total Customers
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
                                        <h4> {{ $total['total_subadmin'] }}</h4><span class="f-light">Total Sub Admin
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
                                        <h4> {{ $total['total_category'] }}</h4><span class="f-light">Total Categories
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
                                        <h4> {{ $total['total_quote'] }}</h4><span class="f-light">Total Quote :</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i class="fa fa-ticket"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_coupon'] }}</h4><span class="f-light">Total Coupon : </span>
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
                                            <i class="fa fa-file-text"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_blog'] }}</h4><span class="f-light">Total Blogs : </span>
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
                                            <i class="fa fa-file-word-o"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_word'] }} </h4><span class="f-light">Total Search Word :
                                        </span>
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
                                            <i class="fa fa-language"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_language'] }} </h4><span class="f-light">Total Languages :
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <i class="fa fa-file"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_active_content'] }}</h4><span class="f-light">Total Active
                                            Content :</span>
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
                                            <i class="fa fa-file-word-o"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_active_subscription'] }} </h4><span class="f-light">Total
                                            Active Subscription : </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round  warning">
                                        <div class="bg-round">
                                            <i class="fa fa-exchange"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_success_transaction'] }}</h4><span class="f-light">Total
                                            Success Transaction :</span>
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
                                            <i class="fa fa-exchange"></i>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4> {{ $total['total_failed_transaction'] }} </h4><span class="f-light">Total
                                            Failed Transaction : </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- total_active_subscription --}}


                </div>
            </div>


            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>New Register Base on Month</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph1"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Transactions Base on Month</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph2"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Booking Base on Month</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph3"></canvas>
                    </div>
                </div>
            </div>



            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Transtions Doughnut Chart</h5>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="myDoughnutGraph1"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-md-6 appointment-sec box-col-6">
                <div class="appointment">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Recent Join Customer</h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="appointment-table table-responsive">
                                <table class="table table-bordernone">
                                    <tbody>
                                        @foreach ($total['customer'] as $customer)
                                            <tr>
                                                <td>
                                                    @if ($customer['profile_image'] == null && $customer['profile_image'] == '')
                                                        <img class="b-r-8 img-40"
                                                            src="{{ static_asset('admin/assets/images/user/user.png') }}"
                                                            alt="Generic placeholder image">
                                                    @else
                                                        <img class="img-fluid img-40 rounded-circle"
                                                            src="{{ static_asset('profile_image/' . $customer->profile_image) }}"
                                                            alt="user">
                                                    @endif
                                                </td>
                                                <td class="img-content-box"><a class="d-block f-w-500"
                                                        href="#">{{ $customer->name }} </a><span
                                                        class="f-light">{{ $customer->email }}</span></td>
                                                <td class="text-end">
                                                    <p class="m-0 font-success">{{ $customer['gender'] }}</p>
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

            <div class="col-xxl-4 col-md-6 appointment-sec box-col-6">
                <div class="appointment">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Recent Serach Words</h5>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="appointment-table table-responsive">
                                <table class="table table-bordernone">
                                    <table class="table table-bordernone">
                                        <tbody>
                                            @foreach ($total['subadmin'] as $subadmin)
                                                <tr>
                                                    <td>
                                                        @if ($subadmin['profile_image'] == null && $subadmin['profile_image'] == '')
                                                            <img class="b-r-8 img-40"
                                                                src="{{ static_asset('admin/assets/images/user/user.png') }}"
                                                                alt="Generic placeholder image">
                                                        @else
                                                            <img class="img-fluid img-40 rounded-circle"
                                                                src="{{ static_asset('profile_image/' . $subadmin->profile_image) }}"
                                                                alt="user">
                                                        @endif
                                                    </td>
                                                    <td class="img-content-box"><a class="d-block f-w-500"
                                                            href="#">{{ $subadmin->name }} </a><span
                                                            class="f-light">{{ $subadmin->email }}</span></td>
                                                    <td class="text-end">
                                                        <p class="m-0 font-success">{{ $subadmin['gender'] }}</p>
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



            <div class="col-xxl-4 col-md-6 appointment-sec box-col-6">
                <div class="appointment">
                    <div class="card">
                        <div class="card-header card-no-border">
                            <div class="header-top">
                                <h5 class="m-0">Recent Transtions</h5>
                                <div class="card-header-right-icon">
                                    <div class="dropdown">
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentButton"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="appointment-table table-responsive">
                                <table class="table table-bordernone">
                                    <tbody>


                                        @foreach ($total['transaction'] as $transtion)
                                            <tr>
                                                <td>{{ $transtion['id'] }}</td>
                                                <td class="img-content-box"><a class="d-block f-w-500"
                                                        href="#">{{ $transtion['payment_mode'] }}</a><span
                                                        class="f-light">{{ $transtion['transaction_type'] }}</span></td>
                                                <td class="text-end">
                                                    <p
                                                        class="m-0 @if ($transtion['status'] == 'success') font-success @else  font-danger @endif">
                                                        {{ $transtion['status'] }} - {{ $transtion['amount'] }}</p>
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

    <!-- Container-fluid Ends-->
@endsection
@section('script')
    <!-- Plugins JS Ends-->

    <script>
        //for Transtions Doughnut Chart  start
        var total_success_transaction = "{{ $total['total_success_transaction'] }}";
        var total_failed_transaction = "{{ $total['total_failed_transaction'] }}";
        var total_pendding_transaction = "{{ $total['total_pendding_transaction'] }}";
        var barchart = {!! json_encode($total['barchart_count']) !!};
        var barchart1 = {!! json_encode($total['barchart_count_1']) !!};

        var doughnutData = [{
                value: total_success_transaction,
                color: "#228B22",
                highlight: "#228B22",
                label: "Success Transtion",
            },
            {
                value: total_failed_transaction,
                color: "#FFC300",
                highlight: "#FFC300",
                label: "Pedding Transtion",
            },
            {
                value: total_pendding_transaction,
                color: "#FF0000",
                highlight: "#FF0000",
                label: "Failed Transtion",
            },
        ];
        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 50,
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        };
        var doughnutCtx = document.getElementById("myDoughnutGraph1").getContext("2d");
        var myDoughnutChart = new Chart(doughnutCtx).Doughnut(
            doughnutData,
            doughnutOptions
        );
        //for Transtions Doughnut Chart end


        //for bar chart start  chart  1

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


         //for bar chart start  chart  2

         var barData = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                "November", "December"
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(60, 179, 113,0.4)",
                strokeColor: "rgba(60, 179, 113)",
                highlightFill: "rgba(60, 179, 113,0.4)",
                highlightStroke: "rgba(60, 179, 113)",
                data: barchart1,
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
        var barCtx = document.getElementById("myBarGraph2").getContext("2d");
        var myBarChart = new Chart(barCtx).Bar(barData, barOptions);



        //for bar chart end




         //for bar chart start  chart  2

         var barData = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                "November", "December"
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(255,250,205,0.4)",
                strokeColor: "#FFC300",
                highlightFill: "rgba(255,250,205,0.4)",
                highlightStroke: "#FFC300",
                data: barchart1,
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
        var barCtx = document.getElementById("myBarGraph3").getContext("2d");
        var myBarChart = new Chart(barCtx).Bar(barData, barOptions);



        //for bar chart end


    </script>
@endsection
