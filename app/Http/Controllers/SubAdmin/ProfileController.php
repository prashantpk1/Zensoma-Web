<?php

namespace App\Http\Controllers\SubAdmin;

use App\Models\Slot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


       /**
     * Display the user's profile form.
     */
    public function subAdminLogin(Request $request)
    {

        // return view('SubAdmin.login');

    }

    //
       /**
     * Display the user's profile form.
     */
    public function sub_admin_dashboard(Request $request)
    {

        $total = [];
        return view('SubAdmin.sub_admin_dashboard');
    }
}
