<?php

use App\Models\Tag;
use App\Models\Badge;
use App\Models\Level;
use App\Models\Option;
use App\Models\Wallet;
use App\Models\Language;
use App\Models\Question;
use App\Models\MySession;
use App\Models\Categories;
use App\Models\UserDetails;
use App\Models\Notification;
use App\Models\MultiLanguage;
use App\Models\GamificationConfig;
use App\Models\PredefinedQuestion;

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}


//get all language
if (!function_exists('get_language')) {

    function get_language()
    {
        $data = Language::select('code','language')->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}


//get all categories
if (!function_exists('get_categories')) {

    function get_categories()
    {
        $data = Categories::select('category_name','id')->where('parent_id',0)->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}



//get all categories
if (!function_exists('get_sub_categories')) {

    function get_sub_categories()
    {
        $data = Categories::select('category_name','id')->where('parent_id', '!=', 0)->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}


//get all categories
if (!function_exists('categories_list')) {

    function categories_list()
    {
        $data = Categories::select('category_name','id')->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}



//get all categories
if (!function_exists('main_categories_list')) {

    function main_categories_list()
    {
        $data = Categories::select('category_name','id')->where('parent_id',0)->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}



//get compressImage
if (!function_exists('compressImage')) {
    function compressImage($source, $destination) {
        // Get image info
        //for $quality change 1 -100
        $quality = 60;
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

         // Check image size
         $fileSize = filesize($source); // in bytes
         $quality = ($fileSize > 1024 * 1024) ? $quality : 100; // Check if size is greater than 1 MB

        // Create a new image from file
        switch($mime){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Save image
        imagejpeg($image, $destination, $quality);

        // Return compressed image
        return $destination;
    }

}



//get raferal code
    if (!function_exists('generate_rederal_code')) {
        function generate_rederal_code() {
                $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    return $referral_code =  substr(str_shuffle($str_result), 0, 6);
        }
    }




//get send_notifications
if (!function_exists('send_notifications')) {
        function send_notifications($user_id,$fcm_token, $device_type, $notification_type, $noti_title,$notification_message)
        {

            //12-03-2024
            $API_ACCESS_KEY = "AAAAfv_kTr4:APA91bGugiqjs8iQftHjd2mWjY43QttZgfPW5HC6RrJf3_YxMVKalfFqUp4jp5rPgqoVenKiPJvBNUiqoI4DcqRVMfkHOleaVlVzfw2y3Th1_nKz0bCj1ZfG2i6uzZfsL5_ruCKMcS4u";


          

            if (!empty($fcm_token)) {
                if ($device_type == "android") {
                    $fields = array(
                        'to'    => $fcm_token,
                        'data'  => array(
                            "title"        => $noti_title,  //Any value
                            "body"         => $notification_message,  //Any value
                            "color"        => "#666666",
                            "sound"        => "default", //If you want notification sound
                            "click_action" => "FCM_PLUGIN_ACTIVITY",  // Must be present for Android
                            "icon"         => "fcm_push_icon",  // White icon Android resource
                            "type"  => $notification_type,
                            "notification_type"  => $notification_type,
                        ),
                    );
                } else {
                    $fields = array(
                        'to'    => $fcm_token,
                        'notification'  => array(
                            "title"        => $noti_title,  //Any value
                            "body"         => $notification_message,  //Any value
                            "color"        => "#666666",
                            "sound"        => "default", //If you want notification sound
                            "click_action" => "FCM_PLUGIN_ACTIVITY",  // Must be present for Android
                            "icon"         => "fcm_push_icon",  // White icon Android resource
                            "type"  => $notification_type,
                            "notification_type"  => $notification_type,
                        ),
                        'data'  => array(
                            "title"        => $noti_title,  //Any value
                            "body"         => $notification_message,  //Any value
                            "color"        => "#666666",
                            "sound"        => "default", //If you want notification sound
                            "click_action" => "FCM_PLUGIN_ACTIVITY",  // Must be present for Android
                            "icon"         => "fcm_push_icon",  // White icon Android resource
                            "type"  => $notification_type,
                            "notification_type"  => $notification_type,
                        ),
                    );
                }


                $headers = array(
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
                // echo "<pre>";
                // print_r($result);

                $data = new Notification();
                $data->user_id = $user_id ?? 0;
                $data->device_type = $device_type;
                $data->notification_type = $notification_type;
                $data->notification_message = $notification_message;
                $data->notification_data = $result ?? "No Result Found";
                $data->is_read = 0;  //(not read == 0 and read = 1)
                $data->save();


                return $data;
            } else {

                $data = new Notification();
                $data->user_id = $user_id ?? 0;
                $data->device_type = $device_type;
                $data->notification_type = $notification_type;
                $data->notification_message = $notification_message;
                $data->notification_data = $result ?? "No Result Found";
                $data->is_read = 0;  //(not read == 0 and read = 1)
                $data->save();

                return array();

            }
            return array();





        }
}

//get question
if (!function_exists('get_question')) {
    function get_question($id) {
        $data = PredefinedQuestion::where('id',$id)->first();
        $question = json_decode($data->question);
        $quetion_en = $question->en ?? "question not found";
        return $quetion_en;

    }
}

// get option
if (!function_exists('get_option')) {
    function get_option($id) {
        $data = Option::where('id',$id)->first();
        $option_en = $data->option ?? "option not found";
        return $option_en;

    }
}


// get option
if (!function_exists('convertToSpecificDateTime')) {
        function convertToSpecificDateTime($originalDate, $newDate, $newTime) {
            // Create a DateTime object from the original date string
            $date = new DateTime($originalDate);

            // Extract year, month, day from newDate
            list($newYear, $newMonth, $newDay) = explode('-', $newDate);

            // Extract hour, minute, second from newTime
            list($newHour, $newMinute, $newSecond) = explode(':', $newTime);

            // Set the desired date and time
            $date->setDate($newYear, $newMonth, $newDay)->setTime($newHour, $newMinute, $newSecond);

            // Format the DateTime object to the desired output format
            return $date->format('M j, Y H:i:s');
        }
}




// get point amount
if (!function_exists('get_point_amount')) {
    function get_point_amount($gamification_config_type) {
        $data = GamificationConfig::where('config_key',$gamification_config_type)->first();
        $amount = $data->config_value ?? 0;
        return $amount;

    }
}


// get point  belance
if (!function_exists('get_user_belance')) {
    function get_user_belance($user_id) {

        $credits = Wallet::where('user_id', $user_id)
        ->where('type', 'credit')
        ->sum('amount');

        $debits = Wallet::where('user_id', $user_id)
            ->where('type', 'debit')
            ->sum('amount');

        $balance = $credits - $debits;
        return $balance;

    }
}


// gamification  calculation
if (!function_exists('gamification_cal')) {
    function gamification_cal($user_id) {
        $levels = Level::where('status',1)->where('is_delete',0)->get();
        $data = UserDetails::where('user_id',$user_id)->first();
          foreach($levels as $level)
          {

                if ($level->level_minute_start <= $data->total_minute_spend && $data->total_minute_spend <= $level->level_minute_end) {
                    // This means the user's total minutes fall within the current level's range
                    $data->current_level_id = $level->id;
                }

          }
          $data->update();




    }
}
// gamification  calculation


// get total minute spend by user
if (!function_exists('get_total_minute')) {
    function get_total_minute($user_id) {

        $total_minute = MySession::where('user_id', $user_id)
        ->sum('minute_spend');


         $data = UserDetails::where('user_id',$user_id)->first();
         $data->total_minute_spend = $total_minute;
         $data->update();

         return $data;


    }
}



// set user badge
if (!function_exists('set_user_badge')) {
    function set_user_badge($user_id) {

        $badges = Badge::where('status',1)->where('is_delete',0)->get();
        $data = UserDetails::where('user_id',$user_id)->first();

        $user_badge = [];
        foreach($badges as $badge)
          {

            $badge_required_minute = 0;
            $badge_required_number_refer = 0;
            $badge_required_challenge = 0;

             if($badge->badge_required_minute <= $data->total_minute_spend){
                      $badge_required_minute = 1;
             }

             if($badge->badge_required_number_refer <= $data->total_refer_count){
                       $badge_required_number_refer = 1;
             }

            if($badge->badge_required_challenge <= $data->total_challenge_complate_count){
                $badge_required_challenge = 1;
            }

            if ($badge_required_minute == 1 && $badge_required_number_refer == 1 && $badge_required_challenge == 1) {
                $user_badge[] = $badge->id;
            }

          }

          $data->badge_ids = $user_badge ?? [""];
          $data->update();



    }
}




//
if (!function_exists('get_label')) {
    function get_label($key,$language_code) {

        $data = MultiLanguage::where('key',$key)->first();
        $array = json_decode($data['content'], true);
     return  $array[$language_code]['content'];


    }
}


//get all tag
if (!function_exists('get_tag')) {

    function get_tag()
    {
        $data = Tag::where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}


//get sub category for edit page
if (!function_exists('get_sub_categories_from_main')) {

    function get_sub_categories_from_main($category_main_id)
    {
        $ids = json_decode($category_main_id);
        $data = Categories::whereIn('parent_id',$ids)->select('category_name','id')->where('status',1)->where('is_delete',0)->get();
        return $data;
    }
}
















