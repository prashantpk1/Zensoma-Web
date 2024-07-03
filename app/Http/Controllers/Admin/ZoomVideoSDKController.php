<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoomVideoSDKController extends Controller
{
    public function createSession(Request $request)
    {
        dd("helo");
        $meetingNumber = $request->input('meeting_number');
        $role = 1; // 1 for host, 0 for attendee
        $signature = $this->generateSignature($meetingNumber, $role);

        return view('create-session', compact('signature', 'meetingNumber'));
    }

    public function joinSession(Request $request)
    {
        $meetingNumber = $request->input('meeting_number');
        $role = 0; // 1 for host, 0 for attendee
        $signature = $this->generateSignature($meetingNumber, $role);

        return view('join-session', compact('signature', 'meetingNumber'));
    }

    private function generateSignature($meetingNumber, $role)
    {
        $apiKey = env('ZOOM_SDK_KEY');
        $apiSecret = env('ZOOM_SDK_SECRET');
        $time = time() * 1000 - 30000; // 30 seconds

        $data = base64_encode($apiKey . $meetingNumber . $time . $role);

        $hash = hash_hmac('sha256', $data, $apiSecret, true);
        $signature = base64_encode($data . '.' . $hash);

        return rtrim($signature, '=');
    }
}
