<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;

class FirebaseService
{
    public function sendToOne(
        string $token,
        string $title,
        string $body,
        array $data = []
    ): bool {


        $projectId = config('services.firebase.project_id');
        $credentialsPath = Storage::path(
            config('services.firebase.credentials')
        );

        if (!file_exists($credentialsPath)) {
            Log::error('Firebase credentials file not found', [
                'path' => $credentialsPath
            ]);
            return false;
        }



        $client = new GoogleClient();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(
            'https://www.googleapis.com/auth/firebase.messaging'
        );
        $client->refreshTokenWithAssertion();

        $accessToken = $client->getAccessToken()['access_token'] ?? null;


        if (!$accessToken) {
            Log::error('Failed to obtain Firebase access token');
            return false;
        }

        $headers = [
            "Authorization: Bearer {$accessToken}",
            'Content-Type: application/json',
        ];

        $payload = json_encode([
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                ],
                "data" => $data,
            ]
        ], JSON_UNESCAPED_UNICODE);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('FCM cURL error', ['error' => $error]);
            return false;
        }

        $decoded = json_decode($response, true);


        dd($decoded);

        if (isset($decoded['error'])) {
            Log::warning('FCM error response', $decoded);
            return false;
        }

        return true;
    }
}
