<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseNotificationService
{
    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.firebase.server_key');
    }

    public function sendNotification($deviceTokens, $title, $body, $data = [])
    {
        if (empty($deviceTokens)) {
            return false;
        }

        $payload = [
            'registration_ids' => $deviceTokens,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default'
            ],
            'data' => $data
        ];

        return Http::withToken($this->serverKey)
            ->post('https://fcm.googleapis.com/fcm/send', $payload)
            ->json();
    }
}
 