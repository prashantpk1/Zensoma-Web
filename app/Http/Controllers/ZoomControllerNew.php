<?php
namespace App\Http\Controllers;

use App\Services\ZoomService;
use Illuminate\Http\Request;

class ZoomControllerNew extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function createSession(Request $request)
    {
        $data = ['role'=>1,'sessionName'=>'first_session','username'=>'dan'];
        $session = $this->zoomService->createSession($data);
        return response()->json($session);
    }
}