<?php

namespace App\Jobs;

use App\Models\Vendor;
use App\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVendorNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $vendorId;
    protected int $reservationId;
    protected string $title;
    protected string $body;
    protected array $data;


    public function __construct(int $vendorId, int $reservationId, string $title, string $body, array $data = [])
    {
        $this->vendorId = $vendorId;
        $this->reservationId = $reservationId;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }



    public function handle(FirebaseService $firebase)
    {
        $vendor = Vendor::select(['id' , 'fcm_token'])->find($this->vendorId);

        if (!$vendor || !$vendor->fcm_token) {
            logger()->warning("Vendor {$this->vendorId} has no FCM token, skipping notification.");
            return;
        }

        $firebase->sendToOne(
            $vendor->fcm_token,
            $this->title,
            $this->body,
            array_merge(['reservation_id' => $this->reservationId], $this->data)
        );

        logger()->info("Notification sent to vendor {$this->vendorId} for reservation {$this->reservationId}");
    }



}
