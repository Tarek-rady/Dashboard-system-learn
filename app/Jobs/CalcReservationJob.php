<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CalcReservationJob implements ShouldQueue
{


    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected int $reservationId;
    protected  $subTotal;

    public $tries = 5;
    public $backoff = [10, 30, 60];

    public function __construct( int $reservationId , $subTotal)
    {
        $this->reservationId = $reservationId ;
        $this->subTotal          = $subTotal ;
    }


    public function handle(): void
    {

        $subTotal= $this->subTotal;
        $tax = 10;
        $subTotal = (($subTotal * $tax) / 100) + $subTotal ;
        $totalDiscount = 0 ;
        $total = $subTotal - $totalDiscount ;




        DB::table('orders')->where('id' , $this->reservationId)->update([
            'cost'           => $subTotal ,
            'total_discount' => $totalDiscount ,
            'tax'            => $tax ,
            'total'          => $total ,
        ]);

    }
}
