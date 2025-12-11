<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    private string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.firebase.server_key');
    }


    public function sendToOne(string $token, string $title, string $body, array $data = [])
    {
        return Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type'  => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ])->throw();
    }


    public function sendToMany(array $tokens, string $title, string $body, array $data = [])
    {
        return Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type'  => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ])->throw();
    }
}
