<?php

namespace App\Services;

use App\Events\ReservationCreatedEvent;
use App\Jobs\CalcReservationJob;
use App\Jobs\SendOfferToVendor;
use App\Models\Order;
use App\Models\Service;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationService
{



    public function createReservation(array $data, $request): int
    {
        return DB::transaction(function () use ($data, $request) {

            $reservationId = $this->storeReservation($data);
            $subTotal = $this->storeReservationServices($reservationId, $request->services);
            $this->dispatchEventsAfterCommit($reservationId , $request->services , $subTotal , $data);
            return $reservationId;
        });
    }


    private function storeReservation(array $data): int
    {
        do {
            $code = 'ORD-' . Str::upper(Str::random(8));
        } while (Order::where('code', $code)->exists());

        $data['code'] = $code;
        $data['user_id'] = auth()->id();
        $data['date_requested'] = CarbonImmutable::now();

        return DB::table('orders')->insertGetId($data);
    }

    private function storeReservationServices(int $reservationId, array $serviceIds): float
    {
        $services = Service::select('id', 'price')
            ->whereIn('id', $serviceIds)
            ->get();

        $subTotal = $services->sum('price');

        $items = $services->map(fn($service) => [
            'order_id'   => $reservationId,
            'service_id' => $service->id,
            'price'      => $service->price,
            'created_at' => now(),
        ]);

        foreach ($items->chunk(1000) as $chunk) {
            DB::table('items')->insert($chunk->toArray());
        }

        return $subTotal;
    }

    private function dispatchEventsAfterCommit(
         int   $reservationId ,
         array $serviceIds ,
         float $subTotal ,
         array $data){


        $userId = (int) auth()->id();



        DB::afterCommit(function() use($reservationId , $userId , $serviceIds , $subTotal ,  $data){

            ReservationCreatedEvent::dispatch(
                $reservationId ,
                $userId ,
                $serviceIds ,
                $subTotal ,
                $data
            );

        });




    }


}
