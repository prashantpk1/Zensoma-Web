<?php
namespace App\Services;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class ZoomService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('ZOOM_SDK_KEY');
        $this->apiSecret = env('ZOOM_SDK_SECRET');
    }

    // public function createSession()
    // {
    //     $url = 'https://api.zoom.us/v2/videosdk/sessions';
    //     $token = $this->generateVideoSdkApiJwt();

    //     // $token = $this->generateJwtToken();

    //     $response = $this->client->get($url, [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . $token,
    //             'Content-Type'  => 'application/x-www-form-urlencoded',
    //         ],
    //         'json' => [
    //             'topic' => 'New Session', // Add other session parameters if required
    //         ],
    //     ]);

    //     dd($response->getBody());

    //     return json_decode($response->getBody(), true);
    // }

    public function createSession($data)
    {
        
        $username = $data['username'] ?? "demo user";
        $role = $data['role'] ?? 1;
        $sessionName = $data['sessionName'] ?? 'Cool Cars';
        $expirationSeconds = $data['expirationSeconds'] ?? '';
        $userIdentity = $data['userIdentity'] ?? '';
        $sessionKey = $data['sessionKey'] ?? '';
        $geoRegions = $data['geoRegions'] ?? '';
        $cloudRecordingOption = $data['cloudRecordingOption'] ?? '';
        $cloudRecordingElection = $data['cloudRecordingElection'] ?? '';
        $audioCompatibleMode = $data['audioCompatibleMode'] ?? '';

        $iat = time();
        $exp = $expirationSeconds ? $iat + $expirationSeconds : $iat + 60 * 60 * 2;
        $oHeader = ['alg' => 'HS256', 'typ' => 'JWT'];

        $oPayload = [
            'app_key' => $this->apiKey,
            'role_type' => $role,
            'tpc' => $sessionName,
            'version' => 1,
            'iat' => $iat,
            'exp' => $exp,
            'user_identity' => $userIdentity,
            'session_key' => $sessionKey,
            'geo_regions' => $this->joinGeoRegions($geoRegions),
            'cloud_recording_option' => $cloudRecordingOption,
            'cloud_recording_election' => $cloudRecordingElection,
            'audio_compatible_mode' => $audioCompatibleMode,
        ];

        $sdkJWT = JWT::encode($oPayload, $this->apiSecret, 'HS256');

        return response()->json(['token' => $sdkJWT, 'sessionName' => $sessionName, 'username' => $username]);
    }

    private function generateJwtToken()
    {

        $payload = [
            'iss' => $this->apiKey,
            'exp' => strtotime('+1 hour'),
        ];

        return JWT::encode($payload, $this->apiSecret, 'HS256');
    }


    private function joinGeoRegions($geoRegions)
    {
        if (is_array($geoRegions)) {
            return implode(',', array_map('strval', $geoRegions));
        }
        return '';
    }

    function generateVideoSdkApiJwt()
    {

        $iat = time() - 30;
        $exp = $iat + 360 * 360 * 2;

        $payload = [
            'iss' => $this->apiKey,
            'iat' => $iat,
            'exp' => $exp,
        ];

        $jwt = JWT::encode($payload, $this->apiSecret, 'HS256');
        return $jwt;
    }

}
