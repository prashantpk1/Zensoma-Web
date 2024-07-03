@extends('layouts.student.app')
@section('title', $title)
@section('content')
    <style>
        form {

            padding: 0;

            display: flex;

            gap: 10px;

            justify-content: start;

        }

        form input[type="text"] {
            width: 100%;
        }


        form label {

            font-size: 1.5rem;

            font-weight: bold;

        }







        a {

            color: #0000ff;

            text-decoration: none;

        }



        a:hover {

            text-decoration: underline;

        }


        #wrapper {
            padding: 15px;
            border: none;
            box-shadow: 0 0px 10px rgba(30, 32, 37, .3);
            border-radius: 10px;
        }

        #wrapper,

        #loginform {

            margin: 0 auto;

            padding-bottom: 25px;

            background: #fff;

            width: 100%;

            max-width: 100%;

            border: none;

            border-radius: 10px;

        }



        #loginform {

            padding-top: 18px;

            text-align: center;

        }



        #loginform p {

            padding: 15px 25px;

            font-size: 1.4rem;

            font-weight: bold;

        }



        #chatbox {

            text-align: left;


            margin-bottom: 25px;

            padding: 10px;

            background: #fff;

            height: 300px;

            width: 100%;

            border: 1px solid #a7a7a7;

            overflow-y: auto;
            overflow-x: hidden;
            flex: 1;
            -webkit-flex:1;

            border-radius: 4px;

            border-bottom: 4px solid #a7a7a7;

        }



        #usermsg {

            flex: 1;

            border-radius: 4px;

            border: 1px solid #3C5D4B;

        }



        #name {

            border-radius: 4px;

            border: 1px solid #ff9800;

            padding: 2px 8px;

        }



        /* #submitmsg,

                #enter {

                    background: #ff9800;

                    border: 2px solid #49e600;

                    color: rgb(255, 255, 255);

                    padding: 4px 10px;

                    font-weight: bold;

                    border-radius: 4px;

                } */



        .error {

            color: #ff0000;

        }



        #menu {

            /* padding: 10px 25px; */

            display: flex;

        }



        #menu p.welcome {

            flex: 1;

        }



        a#exit {

            color: white;

            background: #c62828;

            padding: 4px 8px;

            border-radius: 4px;

            font-weight: bold;

        }



        .msgln {

            margin: 0 0 5px 0;

        }



        .msgln span.left-info {

            color: orangered;

        }



        .msgln span.chat-time {

            color: #666;

            font-size: 60%;

            vertical-align: super;

        }



        .msgln b.user-name,
        .msgln b.user-name-left {

            font-weight: bold;

            background: #546e7a;

            color: white;

            padding: 2px 4px;

            font-size: 90%;

            border-radius: 4px;

            margin: 0 5px 0 0;

        }



        .msgln b.user-name-left {

            background: orangered;

        }

        .chat-info {
            position: relative
        }
        .chat-info:after {
            content: "";
            display: block;
            height: 8px;
            width: 8px;
            border-radius: 50%;
            background-color: #FF0000;
            position: absolute;
            right: 0;
            top: 4px;
        }
        
    </style>
    <main class="">
        <div class="videoCallPage">
            <div class="videoBox d-flex">
                <div class="videoBox-left">
                    <div class="videoBox-left-top d-flex align-items-center justify-content-between">
                        <div class="videoBox-head">
                            <h3 class="font-bd">{{ $class->translateOrDefault()->class_name }}</h3>
                            <div class="duration">
                                <span>{{ count($class->topics) }}
                                    {{ count($class->topics) > 1 ? __('labels.topics') : __('labels.topic') }}</span>
                                <span>{{ getDuration($class->duration) }} {{ __('labels.duration') }}</span>
                            </div>
                        </div>
                        <div class="videoBox-timer d-flex align-items-center">
                            <img src="{{ asset('assets/images/timer.svg') }}" class="img-fluid" alt="timer">
                            <div class="text-white ml-3">
                                <ul class="videoBox-timer_time font-bd list-unstyled mb-0" id="class-timer">
                                    <li><span class="hours">00</span></li>
                                    <li class="seperator">:</li>
                                    <li><span class="minutes">00</span></li>
                                    <li class="seperator">:</li>
                                    <li><span class="seconds">00</span></li>
                                </ul>
                                <span>{{ __('labels.remaining') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="videoBox-thumb" id="videoBox">
                        <div class="videoBox-thumb" id="remote-video" style="display:none">

                        </div>
                        <div style="" class="videoBox-thumb" id="tutorImageScreen">
                            <div class="videoBox-thumb-user">
                                <img src="{{ $class->tutor->profile_image_url }}" class="img-fluid" alt="video-call">
                            </div>
                        </div>
                        <div id="local-video" class="videoBox-thumb-small">
                            {{-- <img src="{{ asset('assets/images/image1.jpg') }}" class="img-fluid" alt="video-call"> --}}
                        </div>
                        <div style="display: none" class="videoBox-thumb-small img-bg" id="studentImageScreen">
                            <div class="videoBox-thumb-user">
                                <img src="{{ Auth::user()->profile_image_url }}" class="img-fluid" alt="video-call">
                            </div>
                        </div>
                    </div>
                    <div class="videoBox-thumb videoBox-thumb--whiteboard" id="whiteBox" style="display: none;">
                        <div id="whiteboard" style="width: 100%; height: 100%;">
                        </div>
                    </div>
                    <div class="videoBox-callPanel d-flex">
                        <div>
                            <a href="javascript:void(0);" class="videoBox-callPanel_link d-lg-none" onclick="userAside()">
                                <span class="icon-chat"></span>
                                {{ __('labels.chat') }}
                            </a>
                        </div>
                        <div class="videoBox-callPanel-center d-flex mx-auto">
                            <a id="extra-hour-btn" href="javascript:void(0);" data-toggle="modal"
                                data-target="#extrachargeModal"
                                class="videoBox-callPanel_link {{ @$extraHourRequest ? 'videoBox-callPanel_link--extraHour' : '' }}"
                                style="{{ @$extraHourRequest && $extraHourRequest->status == 'pending' ? '' : 'display: none' }}">
                                <span class="icon-extra-our"></span>
                                {{ __('labels.extra_hour') }}
                            </a>
                            <a id="live-chat-show-btn-student" href="javascript:void(0);" onclick="livechatshow()"
                                class="videoBox-callPanel_link">
                                <span class="icon-chat"></span>
                                {{ __('message.live_chat') }}
                            </a>
                            <a id="live-chat-hide-btn-student" href="javascript:void(0);" onclick="livechathide()"
                                class="videoBox-callPanel_link d-none">
                                <span class="icon-chat"></span>
                                {{ __('message.live_chat') }}
                            </a>
                            {{-- <a id="raise-hand-btn" href="javascript:void(0);"
                                onclick="raiseHand('{{ $booking->class->id }}')" class="videoBox-callPanel_link">
                                <span class="icon-hand"></span>
                                {{ __('labels.raise_hand') }}
                            </a> --}}
                            <a href="javascript:void(0);" class="videoBox-callPanel_link video video-off"
                            >
                                <span class="icon-video-camera"></span>
                                {{ __('labels.video') }}
                            </a>
                            <a href="javascript:void(0);" class="videoBox-callPanel_link audio mute">
                                <span class="icon-mic"></span>
                                {{ __('labels.mic') }}
                            </a>
                        </div>
                        <a href="javascript:void(0);" onclick="endCall('{{ $booking->id }}')" id="leave"
                            class="videoBox-callPanel_link ml-0">
                            <span class="icon-log-off red"></span>
                            {{ __('labels.end_call') }}
                        </a>
                    </div>
                </div>
                
                <div class="videoBox-right">
                    <div class="alert alert-danger tutor_offline">{{ __('message.tutor_offline') }}</div>
                    
                    <ul id="livechat" class="list-unstyled d-none">
                        
                        <div id="wrapper">
                            
                            <div id="menu">
                                <p>{{ __('message.live_chat') }}<b></b></p><hr>
                                <p class="text-danger">{{ __('message.do_not_share') }}<b></b></p>
                            </div>
                           

                            <div id="chatbox"></div>
                            
                            
                            <form name="message" action="#" id="addchat" method="POST" novalidate>

                                @csrf

                                <input name="message" type="text" id="message"/>
                                
                                <input name="class_id" type="hidden" id="class_id" value="{{ $class->id }}" />

                                <input name="reciver_id" type="hidden" id="reciver_id"
                                    value="{{ $class->tutor_id }}" />

                                <input name="chat_relation_id" type="hidden" id="chat_relation_id"
                                    value=" {{ $chat_relation_id->chat_relation_id }}" />

                                <button name="submitmsg" class="btn btn-primary ripple-effect btn-tutor" type="submit"
                                    id="addchatsubmit" value="Send"> <span class="icon-send red"></span> </button>
    

                                </form>

                        </div>

                       
                        <script type="text/javascript">
                            // jQuery Document

                            $(document).ready(function() {});
                        </script>

                    </ul>

                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="font-eb">{{ __('labels.participants') }} (<span class="participant-count">0</span>)
                        </h4>
                        <a href="javascript:void(0);" class="closeAside d-lg-none" onclick="closeAside()">&times;</a>
                    </div>



                    <ul id="participantsList" class="list-unstyled mb-0 participantList studentParticipantList"
                        nice-scroll>

                    </ul>





                </div>
            </div>
        </div>
    </main>

    <!-- extra charge modal -->
    <div class="modal fade" id="extrachargeModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered commonModal commonModal--charges">
            <div class="modal-content">
                <div class="modal-header align-items-center border-bottom-0">
                    <h5 class="modal-title">{{ __('labels.extra_hour_charge') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="chargesBox">
                        <div class="chargesBox-txtheading">
                            <p><span class="font-bd tutor_name">{{ @$extraHourRequest->class->tutor->name }}</span>
                                {{ __('labels.extra_hour_charge_message') }}</p>
                        </div>
                        <div class="chargesBox-txt text-center">
                            <h5 class="font-bd">{{ __('labels.amount_to_pay') }}</h5>
                            <p class="font-rg textDanger mb-0">{{ __('labels.sar') }} <span
                                    class="font-bd extra_hour_amount">{{ @$extraHourRequest->class->extra_hour_charge }}</span>
                            </p>
                        </div>
                        <div class="chargesBox-txt text-center">
                            <h5 class="font-bd">{{ __('labels.duration') }}</h5>
                            <p class="font-rg mb-0"><span
                                    class="font-bd extra_hour_duration">{{ @$extraHourRequest->class->extra_duration / 60 }}</span>
                                {{ __('labels.hour') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                    <button type="button"
                        class="btn btn-light font-bd ripple-effect textGray extra_hour_reject">{{ __('labels.reject') }}</button>
                    <button type="button"
                        class="btn btn-primary font-bd ripple-effect extra_hour_accept">{{ __('labels.accept') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.7.1.js"></script>
    <script>
        var appId = "{{ config('agora.app_id') }}";
        var token = "{{ $token }}";
        var channelName = "channel-{{ $class->id }}";
        var classType = "{{ $class->class_type }}";
        var uid = {{ Auth::user()->id }}
        var tutorId = {{ $class->tutor_id }}
        var bookingId = {{ $booking->id }}
        var classId = {{ $class->id }}
        var endTime = "{{ $endTime }}";
        var socketUrl = "{{ config('app.socket_url') }}";
        var hasExtraHourRequest = "{{ $extraHourRequest ? 1 : 0 }}";
        var hasRaiseHandRequest = null;
        var profile_image = "{{ Auth::user()->profile_image_url }}";
        var whiteBoardToken = "{{ $whiteBoardToken }}";
        var appIdentifier = "{{ config('agora.app_identifier') }}";
        var region = "{{ config('agora.app_region') }}";
        var uuId = "{{ $class->uuid }}";
        var roomToken = "{{ $class->room_token }}";
    </script>
    <script type="text/javascript" src="{{ config('app.socket_url') }}/socket.io/socket.io.js"></script>
    <script src="https://sdk.netless.link/white-web-sdk/2.13.11.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/student/join-now.js') }}"></script>


    <script>
        $(document).ready(function() {
            var chat_relation_id = '{{ $chat_relation_id->chat_relation_id }}';
            chatList(chat_relation_id);


            var intervalId = window.setInterval(function() {
                // call your function here
                var chat_relation_id = $("#chat_relation_id").val();
                chatList(chat_relation_id);
            }, 5000);


            // $("#hide").click(function(){
            //     $("p").hide();
            // });
            // $("#show").click(function(){
            //     $("p").show();
            // });




        });

        function chatList(chat_relation_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: "{{ route('chat.list') }}",
                data: {
                    chat_relation_id: chat_relation_id,
                },
                success: function(response) {
                    $("#chatbox").html('');
                    $("#chatbox").append(response);
                    $("#chatbox").animate({
                    scrollTop: 500000
                }, 800);
                }
            });
        }
    </script>
@endpush
