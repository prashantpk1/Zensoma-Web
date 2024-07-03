<style>
    .message_info {
        display: flex;
        margin-bottom: 15px
    }

    .message_info .profile {
        margin-right: 10px
    }

    .message_info .box {
	background: #fff;
	box-shadow: 0 5px 10px rgba(30, 32, 37, .12);
	border: 1px solid #c1c1c1;
	padding: 0px 5px;
	margin-bottom: 0;
	border-radius: 7px;
	font-size: 13px;
}

    .message_info .time{
        font-size:12px ;
        margin-bottom: 0;   
        border-top:1px solid #ddd
    }
    .name
    {
        font-size:13px;
        
    }
</style>

@if (count($chatData) > 0)
@foreach ($chatData as $chat)
        <div class="message_info">
            <div class="profile">
                <img src="{{ $chat->sender_data->profile_image_url }}" alt="profile"
                    width="28" height="28" class="rounded-circle">
            </div>

            <div class="right @if(Auth::user()->id  == $chat->sender_data->id) text-success @endif">
                <p class="mb-0 name">{{ $chat->name }}</p>
                <div class="box">
                    <p class="message mb-0">{{ $chat->message }}</p>
                    <p class="time">{{ convertDateToTz($chat->message_time, 'UTC', 'd M Y h:i A') }}</p>
                </div>
               
            </div>
        </div>
    @endforeach
    
@else
  <h2>Start Chat Now..</h2>
@endif
