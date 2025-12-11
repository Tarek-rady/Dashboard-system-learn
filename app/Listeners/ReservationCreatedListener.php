<?php

namespace App\Listeners;

use App\Events\ReservationCreatedEvent;
use App\Jobs\CalcReservationJob;
use App\Jobs\SendOfferToVendor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReservationCreatedListener
{


    public function handle(ReservationCreatedEvent $event): void
    {
        SendOfferToVendor::dispatch(
            $event->reservationId,
            $event->userId,
            $event->serviceIds,
            $event->data
        )->afterCommit();


        CalcReservationJob::dispatch(
            $event->reservationId,
            $event->subTotal
        )->afterCommit();



    }
}
