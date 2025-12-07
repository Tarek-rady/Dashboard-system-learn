<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;


class SendOfferToVendor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected int $reservationId;
    protected int $userId;
    protected array $servicesIds;
    protected array $data;

    public $tries = 5;
    public $backoff = [10, 30, 60];

    public function __construct( int $reservationId , int $userId , array $servicesIds , array $data)
    {
        $this->reservationId = $reservationId ;
        $this->userId        = $userId ;
        $this->servicesIds   = $servicesIds ;
        $this->data          = $data ;
    }


    public function handle(): void
    {

        logger()->info("SendOffersToVendorsJob started for reservation {$this->reservationId}");

       try {

            $requiredCount = count($this->servicesIds);

            $vendorIds = DB::table('vendor_services as vs')
                                ->join('vendors as v' , 'v.id' , '=' , 'vs.vendor_id')
                                ->where('v.is_active' , 1)
                                ->where('v.type' , $this->data['res_type'])
                                ->whereNotNull('v.fcm_token')
                                ->whereIn('vs.service_id', $this->servicesIds)
                                ->groupBy('vs.vendor_id')
                                ->havingRaw('COUNT(DISTINCT vs.service_id) = ?', [$requiredCount])
                                ->pluck('vs.vendor_id')
                                ->unique();


                                if ($vendorIds->isEmpty()) {
                                    logger()->warning("No vendors available for reservation {$this->reservationId}");
                                }


                                $offers = $vendorIds->map(fn($vendorId) => [
                                    'order_id'   => $this->reservationId,
                                    'user_id'    => $this->userId,
                                    'vendor_id'  => $vendorId,
                                    'status'     => 1,
                                    'created_at' => now(),
                                ]);


                                foreach ($offers->chunk(1000) as $chunk) {
                                    DB::table('offers')->insert($chunk->toArray());
                                }

            ;

       } catch (\Throwable $e) {
            logger()->error("SendOffersToVendorsJob error: " . $e->getMessage());

            throw $e;
       }
    }
}
