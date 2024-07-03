<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\ContentManagement;
use App\Models\Coupon;
use App\Models\Language;
use App\Models\Quote;
use App\Models\Slot;
use App\Models\Slot_Details;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\Words;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

      public function page404(Request $request)
    {
        return view('Admin.404');
    }

    public function doHavePermission(Request $request)
    {
        return view('Admin.do_have_permission');
    }


    /**
     * Display the user's profile form.
     */
    public function dashboard(Request $request): View
    {

        $user = Auth::user()->user_type;
        if ($user == 2) {
            $total = [];
            $total['total_language'] = Language::where('is_delete', 0)->count();
            $total['total_blog'] = Blog::where('is_delete', 0)->count();
            $total['total_customer'] = User::where('user_type', 0)->where('is_delete', 0)->count();
            $total['total_subadmin'] = User::where('user_type', 1)->where('is_delete', 0)->count();
            $total['total_word'] = Words::where('is_delete', 0)->count();
            $total['customer'] = User::where('user_type', 0)->orderby('id', 'desc')->where('is_delete', 0)->limit(5)->get();
            $total['subadmin'] = User::where('user_type', 1)->orderby('id', 'desc')->where('is_delete', 0)->limit(5)->get();
            $total['transaction'] = Transaction::orderby('id', 'desc')->limit(5)->get();
            $total['words'] = Words::orderby('volumes', 'desc')->where('is_delete', 0)->limit(5)->get();
            $total['total_category'] = Categories::where('is_delete', 0)->count();
            $total['total_quote'] = Quote::where('is_delete', 0)->count();
            $total['total_coupon'] = Coupon::where('is_delete', 0)->count();
            $total['total_active_content'] = ContentManagement::where('status', 1)->where('is_delete', 0)->count();
            $total['total_success_transaction'] = Transaction::where('status', "success")->where('is_delete', 0)->count();
            $total['total_failed_transaction'] = Transaction::where('status', "failed")->where('is_delete', 0)->count();
            $total['total_pendding_transaction'] = Transaction::where('status', "pendding")->where('is_delete', 0)->count();
            $total['total_active_subscription'] = UserSubscription::where('status', "active")->count();
            $currentDate = Carbon::now();
            // Calculate the date 6 months ago
            $sixMonthsAgo = $currentDate->subMonths(12);
            //Retrieve the new accounts created within the last 12 months and group by month
            $newAccounts = User::where('created_at', '>=', $sixMonthsAgo)
                ->where('is_delete', 0)
                ->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupBy('month')
                ->get();

            // Prepare an array to store the counts for each month
            $counts = [];
            foreach ($newAccounts as $account) {
                // Store the count for each month in the array
                $counts[$account->month] = $account->count;
            }

            // Fill in zero counts for missing months
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($counts[$i])) {
                    $counts[$i] = 0;
                }
            }
            $total['barchart_count'] = $counts ?? [];

            /////Retrieve the new transtion created within the last 12 months and group by month

            $newtran = Transaction::where('created_at', '>=', $sixMonthsAgo)
                ->where('is_delete', 0)
                ->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupBy('month')
                ->get();

            // Prepare an array to store the counts for each month
            $counts = [];
            foreach ($newtran as $tran) {
                // Store the count for each month in the array
                $counts[$tran->month] = $tran->count;
            }

            // Fill in zero counts for missing months
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($counts[$i])) {
                    $counts[$i] = 0;
                }
            }
            $total['barchart_count_1'] = $counts ?? [];

            /////Retrieve the new transtion created within the last 12 months and group by month end
            return view('Admin.admin_dashboard', compact("total"));
        } else {

            $total = [];
            $total['total_day'] = Slot::where('is_delete', 0)->where("user_id", Auth::user()->id)->count();
            $total['total_booking'] = Booking::where("therapist_id", Auth::user()->id)->count();
            $total['booking'] = Booking::with('user_data')->where('therapist_id', Auth::user()->id)->limit(5)->get();
            $total_slot_detail = Slot::where('is_delete', 0)->where("user_id", Auth::user()->id)->get();

            //for chart

            $currentDate = Carbon::now();
            // Calculate the date 6 months ago
            $sixMonthsAgo = $currentDate->subMonths(6);

            $newAccounts = Booking::where('therapist_id', Auth::user()->id)->where('created_at', '>=', $sixMonthsAgo)
                ->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
                ->groupBy('month')
                ->get();

            // Prepare an array to store the counts for each month
            $counts = [];
            foreach ($newAccounts as $account) {
                // Store the count for each month in the array
                $counts[$account->month] = $account->count;
            }

            // Fill in zero counts for missing months
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($counts[$i])) {
                    $counts[$i] = 0;
                }
            }
            $total['barchart_count'] = $counts ?? [];

            $i = 0;
            foreach ($total_slot_detail as $key => $data) {
                $data1 = "";
                $data1 = Slot_Details::where('slot_id', $data->id)->count();
                if ($data1) {
                    $i = $i + $data1;
                }
            }
            $total['number_of_slot'] = $i;
            $total['total_active_content'] = ContentManagement::where('creater_id', Auth::user()->id)->where('status', 1)->where('is_delete', 0)->count();
            return view('SubAdmin.sub_admin_dashboard', compact('total'));

        }

    }

    public function sub_admin_dashboard(Request $request): View
    {

        return view('Admin.Blog.index');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('Admin.profile_edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {

        $request->user()->fill($request->validated());

        $user = Auth::user();
        $data = User::find($user->id);

        // for Image
        if ($request->hasFile('profile_image')) {
            File::delete(public_path('profile_image/' . $data->profile_image));
            // $image = $request->file('profile_image');
            // $uploaded = time() . '_profile_image.' . $image->getClientOriginalExtension();
            // $destinationPath = public_path('/profile_image');
            // $image->move($destinationPath, $uploaded);
            // $data->profile_image = $uploaded;

            $source = $_FILES['profile_image']['tmp_name'];
            if ($source) {
                $destinationFolder = public_path('profile_image'); // Specify the destination folder
                $image = $request->file('profile_image');
                $filename = time() . '_profile_image.' . $image->getClientOriginalExtension();
                if (!file_exists($destinationFolder)) {
                    mkdir($destinationFolder, 0777, true);
                }
                $destination = $destinationFolder . '/' . $filename;
                $profile_image = compressImage($source, $destination);
                $data->profile_image = $filename;
            }

        }

        if (auth()->user()->user_type == 1) {
            $data->designation = $request['designation'];
            $data->biography = $request['biography'];
            $data->skill = $request['basic'];
        }
        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->phone = $request['phone'];
        $data->gender = $request['gender'];
        $data->save();
        if (!empty($data)) {
            // return redirect()->route('setting')->with('success','Profile edit Successfully');
            return response()->json(['status' => '1', 'success' => 'Profile edit Successfully']);
        }
    }

    public function getChangePassword(Request $request)
    {
        return view('Admin.change_password', [
            'user' => $request->user(),
        ]);
    }

    public function storeChangePassword(Request $request)
    {

        $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required',
                'password_confirmation' => ['same:password', 'required'],
            ]
        );
        $pass = Hash::make($request->password);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('setting')->with("error", "Old Password Doesn't match!");
        } else {
            $data = User::find(Auth::id())->update(array('password' => $pass));
            if (!empty($data)) {
                return response()->json(['status' => '1', 'success' => 'Password updated successfully.']);
            }
            // return back()->with("success", " Password updated successfully.");
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function setting(Request $request)
    {
        if (auth()->user()->user_type == 2) {
            return view('Admin.account_setting', [
                'user' => $request->user(),
            ]);
        } else {
            return view('SubAdmin.account_setting', [
                'user' => $request->user(),
            ]);
        }

    }

    public function icon(Request $request): View
    {
        return view('Admin.layouts.checkicon');
    }

    public function getForgotPassword(Request $request)
    {
        return view('Admin.forgot_password');
    }

    public function forgotPassword(Request $request)
    {
        // Your ID to be passed
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user != null || $user != "") {

            $otp = mt_rand(100000, 999999);
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
            return redirect()->route('verify_otp', $userId)->with('success', __('Reset Link Sent Successfully.'));

        } else {

            return redirect()->route('forgot-passwords')->with('error', 'Email Or Account Not Found.....');

        }

    }

    public function getUpdatePassword(Request $request)
    {

        request()->validate([
            'password' => 'required',
            'password_confirmation' => ['same:password', 'required'],
        ]);

    }

    public function verifyOtp($id)
    {

        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $email = $user->email;
        return view('admin.verify_otp', compact('id', 'email'));
    }

    public function verifyOtpCheck(Request $request)
    {

        request()->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $request->email)->first();
        $userId = Crypt::encryptString($user->id);
        $userotp = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if (empty($userotp)) {
            return redirect()->route('verify_otp', $userId)->with('error', 'Otp is Wrong...........');
        } else {
            return redirect()->route('reset.password', $userId)->with('success', 'Otp Verification Successfully.');
        }

    }

    public function resetPassword($id)
    {

        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $email = $user->email;
        return view('admin.update_password', compact('id', 'email'));
    }

    public function resetPasswords(Request $request)
    {
        request()->validate([
            'password' => 'required',
            'confirm_password' => ['same:password'],
        ]);
        $requestData = $request->all();
        $email = User::where('email', $requestData['email'])->first();
        $email->update(['password' => Hash::make($requestData['password'])]);
        return redirect()->route('login')->with('success', __('Password changed successfully'));

    }

}
