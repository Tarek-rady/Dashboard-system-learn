<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int   $reservationId;
    public int   $userId;
    public array $serviceIds;
    public float $subTotal;
    public array $data;

    public function __construct(
        int   $reservationId ,
        int   $userId ,
        array $serviceIds ,
        float $subTotal ,
        array $data)
    {


        $this->reservationId =  $reservationId ;
        $this->userId        =  $userId ;
        $this->serviceIds    =  $serviceIds ;
        $this->subTotal      =  $subTotal ;
        $this->data          =  $data ;

    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
