<?php

namespace App\Http\Controllers\API\V1;

use File;
use Exception;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use App\Models\Badge;
use App\Models\Level;
use App\Models\Theme;
use App\Models\Wallet;
use App\Models\Language;
use App\Models\MySession;
use App\Models\Categories;
use App\Models\Transaction;
use App\Models\UserDetails;
use App\Models\BuddyNetwork;
use App\Models\CategoryType;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\WalkReminder;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\SleepReminder;
use App\Models\UserSleepDetail;
use App\Models\PredefinedAnswer;
use App\Models\UserSubscription;
use App\Models\BuddyNetworkDetail;
use App\Models\DrinkWaterReminder;
use App\Models\GamificationConfig;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\AccountResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\CategoryMasterResource;

class AccountController extends Controller
{
    //

    public function login(Request $request)
    {

        $language = $request->header('language');
        $language_code = $request->header('language');
        $language = Language::where('code', $language)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }


        $validated = [];
        $validated['login_type'] = "required";
        $validated['email'] = "required";
        $validated['password'] = "required_if:login_type,0";
        $customMessages = [
            'login_type.required' => get_label("this_field_is_required",$language_code),
            'email.required' => get_label("this_field_is_required",$language_code),
            'password.required_if' => get_label("the_password_field_is_required_when_login_type_is_0",$language_code)
        ];

       $request->validate($validated, $customMessages);

        try {

            $user = User::where("email", $request->email)->where("is_delete", 0)->first();


            $fcm_token = $request->fcm_token;
            $device_type = $request->device_type;


            if (!empty($user)) {

                if ($user->user_type == 0) {



                                                            if ($request->login_type == 0) {

                                                                $data = [
                                                                    'email' => $request->email,
                                                                    'password' => $request->password,
                                                                ];

                                                                if (auth()->attempt($data)) {
                                                                    $token = auth()->user()->createToken('auth')->accessToken;
                                                                    $array = Auth::user();
                                                                    $array['token'] = $token;

                                                                    //
                                                                    // for predifened question
                                                                    $data_pre = PredefinedAnswer::where('user_id', Auth::user()->id)->first();
                                                                    if (!empty($data_pre)) {
                                                                        $array['is_predefined_submit'] = 1;
                                                                    } else {
                                                                        $array['is_predefined_submit'] = 0;
                                                                    }

                                                                    $user->device_type = $device_type ?? "";
                                                                    $user->fcm_token = $fcm_token ?? "";
                                                                    $user->update();

                                                                    set_user_badge($user->id);


                                                                    //
                                                                    $data = new AccountResource($array);
                                                                    return response()->json(
                                                                        [
                                                                            'data' => $data,
                                                                            'status' => 1,
                                                                            'message' => get_label("login_successfully",$language_code),
                                                                        ], 200);
                                                                } else {
                                                                    return response()->json(
                                                                        [
                                                                            'message' => get_label("incorrect_email_id_and_password..",$language_code),
                                                                            'status' => 0,
                                                                        ]
                                                                        , 200);
                                                                }
                                                            } else {
                                                                $user = User::where('email', $request->email)->first();
                                                                if ($user) {
                                                                    $token = $user->createToken('Auth Login')->accessToken;

                                                                    $user->device_type = $device_type ?? "";
                                                                    $user->fcm_token = $fcm_token ?? "";
                                                                    $user->update();

                                                                    $user['token'] = $token;

                                                                    // for predifened question
                                                                    $data_pre = PredefinedAnswer::where('user_id', $user->id)->first();
                                                                    if (!empty($data_pre)) {
                                                                        $user['is_predefined_submit'] = 1;
                                                                    } else {
                                                                        $user['is_predefined_submit'] = 0;
                                                                    }





                                                                    //
                                                                    $data = new AccountResource($user);

                                                                    set_user_badge($user->id);

                                                                    return response()->json(
                                                                        [
                                                                            'data' => $data,
                                                                            'status' => 1,
                                                                            'message' => get_label("login_successfully",$language_code),
                                                                        ], 200);

                                                                }

                                                            }




                                } else {
                                    return response()->json(
                                        [
                                            'message' => get_label("incorrect_email_id_and_password..",$language_code),
                                            'status' => 0,
                                        ]
                                        , 200);
                                }


            } else {
                return response()->json(
                    [
                        'message' => get_label("incorrect_email_id_and_password..",$language_code),
                        'status' => 0,
                    ]
                    , 200);
            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function socialRegister(Request $request)
    {

        $language_code = $request->header('language');

        $validated = [];
        $validated['name'] = "required|min:4";
        $validated['phone'] = "required|min:8";
        $validated['email'] = "required|email|unique:users,email";


        $customMessages = [
            'name.required' => get_label("the_name_field_is_required",$language_code),
            'name.min' => get_label("the_name_must_be_at_least_4_characters",$language_code),
            'phone.required' => get_label("the_phone_field_is_required",$language_code),
            'phone.min' => get_label("the_phone_number_must_be_at_least_8_characters",$language_code),
            'email.required' =>  get_label("the_email_field_is_required",$language_code),
            'email.email' =>  get_label("the_email_must_be_a_valid_email_address",$language_code),
            'email.unique' =>  get_label("this_email_is_already_take",$language_code),
        ];

       $request->validate($validated, $customMessages);


        try {

            if($request->referral_code)
            {
                 $user_reciver = User::where("referral_code",$request->referral_code)->first();
                       if($user_reciver)
                       {

                       }
                       else
                       {
                        return response()->json(
                            [
                                'status' => 1,
                                'message' => get_label("incorrect_referral_code",$language_code),
                            ], 500);
                       }
            }


            $referral_code = generate_rederal_code();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                // 'device_type' => $request->device_type,
                // 'fcm_token' => $request->fcm_token,
                'user_type' => 0,
                'status' => 0,
                'is_approved' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
            ]);

            $BuddyNetwork = BuddyNetwork::create([
                'user_id' => $user->id,
                'referral_code' => $referral_code ?? '',
                'number_of_refer' => 0,
                'status' => 0,
            ]);


            //update token and device_type
            $user->device_type = $device_type ?? "";
            $user->fcm_token = $fcm_token ?? "";
            $user->update();



            $token = $user->createToken('auth')->accessToken;

            $subscription = Subscription::where("is_default",1)->first();


            if($subscription)
            {
                        // set free subscription to customer

                        $plan_days = $subscription->duration;

                        $currentDate = Carbon::now();

                        // Add subscription duration days to the current date
                        $newDate = $currentDate->copy()->addDays($plan_days);

                        // Format the dates as "Y-m-d"
                        $start_Date = $currentDate->format('Y-m-d');
                        $end_Date = $newDate->format('Y-m-d');

                        $transaction_data = new Transaction();
                        $transaction_data->user_id = $user->id ?? 0;
                        $transaction_data->subscription_id = $subscription->id ?? 0;
                        $transaction_data->payment_mode = "direct_payment";;
                        $transaction_data->transaction_type = "subscription";
                        $transaction_data->amount = $subscription->amount ?? 0;
                        $transaction_data->status = "success";
                        $transaction_data->save();

                        if($transaction_data)
                        {


                            $purchase_subscription = new UserSubscription();
                            $purchase_subscription->user_id = $user->id ?? 0;
                            $purchase_subscription->transaction_id = $transaction_data->id ?? 0;
                            $purchase_subscription->subscription_id = $subscription->id ?? 0;
                            $purchase_subscription->plan_duration = $subscription->duration ?? 0;
                            $purchase_subscription->start_date = $start_Date;
                            $purchase_subscription->end_date = $end_Date;
                            $transaction_data->active = "success";
                            $purchase_subscription->save();

                           $check_send_notification =  send_notifications($user->id,$fcm_token ?? 0,$device_type ?? "Android","Push_notification","update_subscripotion","update_subscripotion_succesfully");

                        }

                        // set free subscription to customer
            }


               //give referal point
               if($request->referral_code)
               {

                          if($user_reciver)
                          {
                                      $amount  =  get_point_amount("refer_a_friend_to_earn");
                                      if($amount >= 0) {
                                                         $user_wallet = new Wallet();
                                                         $user_wallet->user_id  = $user_reciver->id;
                                                         $user_wallet->type = "credit";
                                                         $user_wallet->amount = $amount;
                                                         $user_wallet->save();
                                     }

                                     $user_details = UserDetails::where("user_id",$user_reciver->id)->first();
                                     if($user_details) {
                                         $user_details->total_refer_count =  $user_details->total_refer_count + 1;
                                         $user_details->update();

                                     }

                          }
                          else
                          {

                              return response()->json(
                                 [
                                     'data' => $data,
                                     'status' => 1,
                                     'message' => get_label("incorrect_referral_code",$language_code),
                                 ], 500);

                          }
            }

          // get default
            $get_default_level = Level::where('is_default',1)->first();


            $user_detail = UserDetails::create([
                'user_id' => $user->id ?? 0,
                'total_refer_count' => 0,
                'total_challenge_complate_count' => 0,
                'total_minute_spend' => 0,
                'current_level_id' => $get_default_level->id ?? 0,
                'badge_ids' => [],
            ]);






            $user['token'] = $token;
            $data = new AccountResource($user);

            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("regiter_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => $ex->getMessage(),
                    ], 401);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function register(Request $request)
    {

        $language_code = $request->header('language');

        $validated = [];
        $validated['name'] = "required|min:4";
        $validated['phone'] = "required|min:8";
        $validated['email'] = "required|email|unique:users,email";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";
        $validated['country_id'] = "required";


        $customMessages = [
            'name.required' => get_label("the_name_field_is_required",$language_code),
            'name.min' => get_label("the_name_must_be_at_least_4_characters",$language_code),
            'phone.required' => get_label("the_phone_field_is_required",$language_code),
            'phone.min' => get_label("the_phone_number_must_be_at_least_8_characters",$language_code),
            'email.required' =>  get_label("the_email_field_is_required",$language_code),
            'email.email' =>  get_label("the_email_must_be_a_valid_email_address",$language_code),
            'email.unique' =>  get_label("This_email_is_already_take",$language_code),
            'password.required' => get_label("the_password_field_is_required",$language_code),
            'confirm_password.same' => get_label("the_confirm_password_must_match_the_password",$language_code),
            'confirm_password.required' =>  get_label("the_confirm_password_field_is_required",$language_code),
            'country_id.required' => get_label("the_country_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);

        try {

            $referral_code = generate_rederal_code();

            if($request->referral_code)
            {
                 $user_reciver = User::where("referral_code",$request->referral_code)->first();
                       if($user_reciver)
                       {

                       }
                       else
                       {
                        return response()->json(
                            [
                                'status' => 1,
                                'message' => get_label("incorrect_referral_code",$language_code),
                            ], 500);
                       }
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'user_type' => 0,
                'status' => 0,
                'is_approved' => 1,
                'password' => Hash::make($request->password),
                'referral_code' => $referral_code ?? '',
            ]);

            $BuddyNetwork = BuddyNetwork::create([
                'user_id' => $user->id,
                'referral_code' => $referral_code ?? '',
                'number_of_refer' => 0,
                'status' => 0,
            ]);

            $token = $user->createToken('auth')->accessToken;

            $subscription = Subscription::where("is_default",1)->first();

            if($subscription)
            {
                        // set free subscription to customer

                        $plan_days = $subscription->duration;

                        $currentDate = Carbon::now();

                        // Add subscription duration days to the current date
                        $newDate = $currentDate->copy()->addDays($plan_days);

                        // Format the dates as "Y-m-d"
                        $start_Date = $currentDate->format('Y-m-d');
                        $end_Date = $newDate->format('Y-m-d');

                        $transaction_data = new Transaction();
                        $transaction_data->user_id = $user->id ?? 0;
                        $transaction_data->subscription_id = $subscription->id ?? 0;
                        $transaction_data->payment_mode = "direct_payment";;
                        $transaction_data->transaction_type = "subscription";
                        $transaction_data->amount = $subscription->amount ?? 0;
                        $transaction_data->status = "success";
                        $transaction_data->save();

                        if($transaction_data)
                        {


                            $purchase_subscription = new UserSubscription();
                            $purchase_subscription->user_id = $user->id ?? 0;
                            $purchase_subscription->transaction_id = $transaction_data->id ?? 0;
                            $purchase_subscription->subscription_id = $subscription->id ?? 0;
                            $purchase_subscription->plan_duration = $subscription->duration ?? 0;
                            $purchase_subscription->start_date = $start_Date;
                            $purchase_subscription->end_date = $end_Date;
                            $transaction_data->active = "success";
                            $purchase_subscription->save();

                           $check_send_notification =  send_notifications($user->id,$fcm_token ?? 0,$device_type ?? "Android","Push_notification","update_subscripotion","update_subscripotion_succesfully");

                        }

                        // set free subscription to customer
            }


              //give referal point
              if($request->referral_code)
              {
                        if($user_reciver)
                         {
                                     $amount  =  get_point_amount("refer_a_friend_to_earn");
                                     if($amount >= 0) {
                                                        $user_wallet = new Wallet();
                                                        $user_wallet->user_id  = $user_reciver->id;
                                                        $user_wallet->type = "credit";
                                                        $user_wallet->amount = $amount;
                                                        $user_wallet->save();
                                    }


                                    $user_details = UserDetails::where("user_id",$user_reciver->id)->first();
                                    if($user_details) {
                                        $user_details->total_refer_count =  $user_details->total_refer_count + 1;
                                        $user_details->update();

                                    }




                         }
                         else
                         {

                             return response()->json(
                                [
                                    'status' => 1,
                                    'message' => get_label("incorrect_referral_code",$language_code),
                                ], 500);

                         }







              }


            // get default
            $get_default_level = Level::where('is_default',1)->first();


              $user_detail = UserDetails::create([
                'user_id' => $user->id ?? 0,
                'total_refer_count' => 0,
                'total_challenge_complate_count' => 0,
                'total_minute_spend' => 0,
                'current_level_id' => $get_default_level->id ?? 0,
                'badge_ids' => [],
            ]);




            $user['token'] = $token;
            $data = new AccountResource($user);

            if ($data) {
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("regiter_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => $ex->getMessage(),
                    ], 401);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function forgotPassword(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['email'] = "required|email";

        $customMessages = [
            'email.required' =>  get_label("the_email_field_is_required",$language_code),
            'email.email' =>  get_label("the_email_must_be_a_valid_email_address",$language_code),
        ];

       $request->validate($validated, $customMessages);


        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user != null || $user != "") {

                // $otp = mt_rand(100000, 999999);
                $otp = 123456;
                $user->otp = $otp;
                $user->update();
                $userId = Crypt::encryptString($user->id);

                Mail::send(
                    ['html' => 'email.forget_password_template'],
                    array(
                        'otp' => $otp,
                        'email' => $email,
                    ),
                    function ($message) use ($email) {
                        $message->from(env('MAIL_USERNAME'), 'Zensoma');
                        $message->to($email);
                        $message->subject("Verify your OTP");
                    }
                );
                $user['token'] = null;
                $data = new AccountResource($user);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' =>  get_label("otp_send_successfully",$language_code),
                    ], 200);

            } else {

                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("email_or_account_not_found",$language_code),
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }

    public function verifyOTP(Request $request)
    {

         $language_code = $request->header('language');

        $validated = [];
        $validated['user_id'] = "required";
        $validated['otp'] = "required|min:6|max:6";

        $customMessages = [
            'user_id.required' => get_label("the_user_id_field_is_required",$language_code),
            'otp.required' =>  get_label("the_otp_field_is_required",$language_code),
            'otp.min' => get_label("the_otp_must_be_exactly_6_digits",$language_code),
            'otp.max' => get_label("the_otp_must_be_exactly_6_digits",$language_code),
        ];

       $request->validate($validated, $customMessages);

        try {
            $user = User::find($request->user_id)->first();
            $userotp = User::where('id', $request->user_id)->where('otp', $request->otp)->first();
            if (!empty($userotp)) {
                $user['token'] = null;
                $data = new AccountResource($user);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("otp_verify_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  get_label("otp_not_match",$language_code),
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function resetPassword(Request $request)
    {

        $language_code = $request->header('language');
        $validated = [];
        $validated['user_id'] = "required";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";

        $customMessages = [
            'user_id.required' => get_label("the_user_id_field_is_required",$language_code),
            'password.required' => get_label("the_password_field_is_required",$language_code),
            'confirm_password.same' => get_label("the_confirm_password_must_match_the_password",$language_code),
            'confirm_password.required' =>  get_label("the_confirm_password_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);

        try {

            $data = User::where('id', $request['user_id'])->first();
            $data->update(['password' => Hash::make($request['password'])]);

            if (!empty($data)) {
                return response()->json(
                    [
                        'status' => 1,
                        'message' => get_label("password_reset_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'status' => 0,
                        'message' => get_label("password_not_reset",$language_code),
                    ], 200);

            }

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function profile(Request $request)
    {
        try {
            $language_code = $request->header('language');

            $user = User::find(Auth::user()->id);
            $user['drink_water_detail'] = DrinkWaterReminder::where('user_id',$user->id)->select('id','user_id','reminder_start_time','reminder_end_time','reminder_type','remind_me_every_hour_number','reminder_me_every_day_at','reminder_switch')->first();
            $user['sleep_detail'] = SleepReminder::where('user_id',$user->id)->first();
            $user['walk_detail'] = WalkReminder::where('user_id',$user->id)->first();
            $user['user_sleep_detail'] =  UserSleepDetail::where('sleep_start_date', '>=', Carbon::now()->subDays(7))->orderBy('sleep_start_date', 'desc')->get();
            if (!empty($user)) {
                $data = new ProfileResource($user);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' => get_label("profile_get_successfully",$language_code),
                    ], 200);
            } else {
                return response()->json(
                    [
                        'message' => get_label("profile_not_found",$language_code),
                        'status' => 0,
                    ]
                    , 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function editProfile(Request $request)
    {
        $language_code = $request->header('language');

        $id = Auth::user()->id;
        $validated = [];
        $validated['name'] = "required";
        $validated['email'] = "required|email|unique:users,email," . $id;
        $validated['phone'] = "required";

        $customMessages = [
            'name.required' => get_label("the_name_field_is_required",$language_code),
            'name.min' => get_label("the_name_must_be_at_least_4_characters",$language_code),
            'phone.required' => get_label("the_phone_field_is_required",$language_code),
            'phone.min' => get_label("the_phone_number_must_be_at_least_8_characters",$language_code),
            'email.required' =>  get_label("the_email_field_is_required",$language_code),
            'email.email' =>  get_label("the_email_must_be_a_valid_email_address",$language_code),
            'email.unique' =>  get_label("this_email_is_already_take",$language_code),
        ];


       $request->validate($validated, $customMessages);


        try {

            $auth = User::find($id);
            $auth->name = $request->name;
            $auth->email = $request->email;
            $auth->phone = $request->phone;

            if ($request->gender) {
                $auth->gender = $request->gender;
            }

            if ($request->avtar_json) {
                $auth->avtar_json = $request->avtar_json;
            }

            if ($request->age) {
                $auth->age = $request->age;
            }

            if ($request->height) {
                $auth->height = $request->height;
            }

            if ($request->height_value_type) {
                $auth->height_value_type = $request->height_value_type;
            }

            if ($request->weight) {
                $auth->weight = $request->weight;
            }

            if ($request->weight_value_type) {
                $auth->weight_value_type = $request->weight_value_type;
            }

            if ($request->tag_id) {
                $auth->tag_id = $request->tag_id;
            }


            // for Image
            if ($request->hasFile('profile_image')) {
                File::delete(public_path('profile_image/' . $auth->profile_image));
                $image = $request->file('profile_image');
                $uploaded = time() . '_profile_image.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/profile_image');
                $image->move($destinationPath, $uploaded);
                $auth->profile_image = $uploaded;
            }

            $auth->save();
            if (!empty($auth)) {
                $data = new ProfileResource($auth);
                return response()->json(
                    [
                        'data' => $data,
                        'status' => 1,
                        'message' =>  get_label("profile_update_successfully",$language_code),
                    ], 200);
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function changePassword(Request $request)
    {

        $language_code = $request->header('language');

        $validated = [];
        // $validated['user_id'] = "required";
        $user_id = Auth::user()->id;

        $validated['current_password'] = "required";
        $validated['password'] = "required";
        $validated['confirm_password'] = "same:password|required";


        $customMessages = [
            'user_id.required' => get_label("the_user_id_field_is_required",$language_code),
            'current_password.required' => get_label("the_current_password_field_is_required",$language_code),
            'password.required' => get_label("the_password_field_is_required",$language_code),
            'confirm_password.same' => get_label("the_confirm_password_must_match_the_password",$language_code),
            'confirm_password.required' =>  get_label("the_confirm_password_field_is_required",$language_code),
        ];

       $request->validate($validated, $customMessages);


        try {
            $auth = User::find($user_id);

            // The passwords matches
            if (!Hash::check($request->current_password, $auth->password)) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  get_label("current_password_is_invalid",$language_code),
                    ], 200);
            }

            // Current password and new password same
            if (strcmp($request->current_password, $request->password) == 0) {
                return response()->json(
                    [
                        'status' => 0,
                        'message' =>  get_label("new_password_cannot_be_same_as_your_current_password",$language_code),
                    ], 200);
            }

            $auth->password = Hash::make($request->password);
            $auth->update();
             return response()->json(
                [
                    'status' => 1,
                    'message' =>  get_label("password_changed_successfully",$language_code),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }

    public function logout(Request $request)
    {

        $language_code = $request->header('language');

        if ($request->user()) {
            $request->user()->token()->revoke();
            return response()->json(
                [
                    'status' => 1,
                    'message' => get_label("logout_successfully",$language_code),
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => get_label("somthing_went_wrong",$language_code),
                ], 200);
        }

    }


    public function dashboard(Request $request)
    {
        
        $language = $request->header('language');
        $language_code = $request->header('language');
        $language = Language::where('code', $language)->where('status', 1)->where('is_delete', 0)->first();
        if (empty($language)) {
            return response()->json(
                ['status' => 0, 'message' => 'Invalied Language Code'], 401
            );
        }
        try {
            
            if(!empty($request['user_id']))
            {
                $user_id =  $request['user_id'];
                $user = User::find($user_id);
                $user['user_name'] = $user['name'];
                $user['profile_image'] = URL::to('/public') . '/profile_image/' . $user['profile_image'] ?? "user.jpg";
                $user['theme_id'] =   $user['theme_id'];
                          $user['tag_id'] =   $user['tag_id'];
                          $data['user'] = $user;


                        // Step 1: Get all category_id values
                        $categories = MySession::pluck('category_id');
                        
                        // Step 2: Process the data
                        $allCategoryIds = $categories->map(function ($item) {
                            return json_decode($item, true);
                        })->flatten()->unique()->values()->all();
                        
                        
                        
                        $data_my_session = Categories::whereIn('id',$allCategoryIds)->limit(5)->get();
                        //   $data_my_session = Categories::where('parent_id',0)->inRandomOrder()->limit(5)->get();
                        $my_session_data = CategoryResource::collection($data_my_session);
                        
                        
                        
                        //get notification unread  notification count
                          $notification_count = Notification::where("user_id",$user_id)->where('is_read',0)->count();
                          $data['unread_notification_count'] = $notification_count ?? 0;
                          //get notification unread  notification count
                    
                        


            }
            else
            {
                            $user['user_name'] = "Guest User";
                            $user['profile_image'] = URL::to('/public') . '/profile_image/user.jpg';
                            $user['theme_id'] = 1;
                            $data['user'] = $user;
                            $my_session_data  = "";

            }

            //for category
            $data_cate = Categories::select('id', 'category_name', 'icon', 'category_image')->where('parent_id', 0)->where('status', 1)->where('is_delete', 0)->inRandomOrder()->limit(5)->get();
            foreach ($data_cate as $cat) {
                //for language main category
                $category_name_array = json_decode($cat['category_name']);
                $category_name_en = $category_name_array->$language_code->category_name;
                $cat['category_name'] = $category_name_en ?? "No Category Name Found";
                $cat['icon'] = URL::to('/public') . '/icon/' . $cat->icon ?? "";
                $cat['category_image'] = URL::to('/public') . '/category_image/' . $cat->category_image ?? "";
                //for language main category

                $sub_category = Categories::select('id', 'category_name', 'icon', 'category_image')->where('parent_id', $cat->id)->where('status', 1)->where('is_delete', 0)->get();
                foreach ($sub_category as $sub_cate) {
                    
                    $sub_category_name_array = json_decode($sub_cate['category_name']);
                    $category_name_en = $sub_category_name_array->$language_code->category_name;
                    $sub_cate['sub_category_name'] = $category_name_en ?? "No Category Name Found";
                    $sub_cate['icon'] = URL::to('/public') . '/icon/' . $sub_cate->icon ?? "";
                    $sub_cate['category_image'] = URL::to('/public') . '/category_image/' . $sub_cate->category_image ?? "";

                    $type = CategoryType::select('id', 'type')->where('category_id', $sub_cate->id)->get();
                    foreach ($type as $ty) {
                        $type_array = json_decode($ty['type']);
                        $type_name_en = $type_array->$language_code->type;
                        $ty['type'] = $type_name_en ?? "No Category Name Found";
                    }
                    $sub_cate['Types'] = $type;

                    unset($sub_cate['category_name']);
                }
                $cat['sub_categories'] = $sub_category;
            }
            
            $cate_data = CategoryMasterResource::collection($data_cate);
           //for category end

            $data_adv = Advertisement::where('status', 1)->where('is_delete', 0)->get();
            $adv = AdvertisementResource::collection($data_adv);

          

            if ($user['theme_id'] != 0) {
                $theme = Theme::select('title', 'thumbnail', 'file', 'status', 'is_default')->where('id', $user['theme_id'])->where('status', 1)->where('is_delete', 0)->first();
            } else {
                $theme = Theme::select('title', 'thumbnail', 'file', 'status', 'is_default')->where('is_default', 1)->first();
            }

            $theme_title = json_decode($theme['title']);
            $theme_title_language = $theme_title->$language_code->title;
            $theme['title'] = $theme_title_language ?? "Theme Title Found";

            $theme['thumbnail'] = URL::to('/public') . '/thumbnail_image/' . $theme->thumbnail ?? "";
            $theme['file'] = URL::to('/public') . '/file/' . $theme->file ?? "";

            //get all tag from db for how_do_you_feel_today
            $data_adv = Tag::where('status', 1)->where('is_delete',0)->get();
            $how_do_you_feel_today = TagResource::collection($data_adv);
            //get all tag from db for how_do_you_feel_today

             //get GamificationConfig unread  GamificationConfig count
             $GamificationConfig_count = GamificationConfig::select('config_key','config_value')->where('config_key','refer_a_friend_to_earn')->first();
             $data['per_refer_reward'] = $GamificationConfig_count ?? "";
             //get GamificationConfig unread  GamificationConfig count
           



            $data['my_session'] = $my_session_data ?? "";
            $data['categories'] = $cate_data ?? "";
            $data['advertisement'] = $adv ?? "";
            $data['theme'] = $theme ?? "";
            $data['how_do_you_feel_today'] = $how_do_you_feel_today ?? "";

            return response()->json(
                [
                    'data' => $data,
                    'status' => 1,
                    'message' => get_label("dashboard_data_get_successfully",$language_code),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }

    }




    public function deleteAccount(Request $request)
    {

        $language_code = $request->header('language');
        if ($request->user()) {
            $data = User::find(Auth::user()->id);
            $data->is_delete = 1;
            $data->update();
            $request->user()->token()->revoke();
            return response()->json(
                [
                    'status' => 1,
                    'message' => get_label("user_acoount_delete_successfully",$language_code),
                ], 200);
        } else {
            return response()->json(
                [
                    'status' => 0,
                    'message' => get_label("somthing_went_wrong",$language_code),
                ], 200);
        }

    }


    public function checkContactRegisterOrNot(Request $request)
    {

        $language_code = $request->header('language');
        $contact_array = json_decode($request->contact_array, true);

        $registered_users = [];
        $unregistered_contacts = [];

        foreach($contact_array as $array) {
            $number = $array['number'];
            $display_name = $array['displayName'];
            $check_number = User::where("phone", $number)->first();

            if ($check_number) {
                // If the number is found in the User table, add it to the registered_users array
                $registered_users[] = [
                    'number' => $number,
                    'displayName' => $display_name
                ];
            } else {
                // If the number is not found in the User table, add it to the unregistered_contacts array
                $unregistered_contacts[] = [
                    'number' => $number,
                    'displayName' => $display_name
                ];
            }
        }

       if($registered_users){
               return response()->json(
                [
                    'status' => 0,
                    'registered' => $registered_users,
                    'unregistered' => $unregistered_contacts,
                    'message' => get_label("contact_checking_succesfully",$language_code),
                ], 200);
        }

    }


    public function  getUserGamificationDetail(Request $request)
    {


        try {

            $language = $request->header('language');
            $user_detail = UserDetails::select('id','user_id','total_refer_count','total_challenge_complate_count','total_minute_spend','current_level_id','badge_ids')->where('user_id',Auth::user()->id)->first();
            $user_level =  Level::find($user_detail->current_level_id);
            $array = json_decode($user_level['level_name'], true);

            $level = [];
            $level['level_number'] = $user_level->id;
            $level['level_name'] = $array[$language]['level_name'];
            $level['level_start'] = $user_level->level_minute_start;
            $level['level_current_minutes'] = $user_detail->total_minute_spend;
            $level['level_end'] = $user_level->level_minute_end;

            $badges = Badge::select('id','badge_name','badge_image','status')->where('status',1)->where('is_delete',0)->get();

            $user_detail->user_level = $level;
             foreach ($badges as $badge) {
                    if (in_array($badge->id, $user_detail->badge_ids)) {
                        $badge->is_won = 1;
                    } else {
                        $badge->is_won = 0;
                    }

                    $badge->badge_image = URL::to('/public') . '/badge_image/' . $badge->badge_image;

                    $array = json_decode($badge['badge_name'], true);
                    $badge->badge_name = $array[$language]['badge_name'] ?? "";


            }

            $user_detail->badges = $badges;


            //gamification rule
            $gamification_rules = GamificationConfig::select('id','config_name','config_key','config_value')->where('status',1)->where('is_delete',0)->get();
            if($gamification_rules) {
            foreach ($gamification_rules as $gamification_rule) {

                        $array = json_decode($gamification_rule['config_name'], true);
                        $gamification_rule->config_name = $array[$language]['config_name'] ?? "";



              }
             }
            //gamification rule

            $user_detail->user_belance = get_user_belance(Auth::user()->id) ?? 0;
            $user_detail->gamification_rules = $gamification_rules ?? "";

            return response()->json(
                [
                    'data' => $user_detail,
                    'status' => 1,
                    'message' => get_label("user_gamification_get_successfully",$language),
                ], 200);

        } catch (Exception $ex) {
            return response()->json(
                ['success' => 0, 'message' => $ex->getMessage()], 401
            );
        }
    }












}
