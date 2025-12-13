<?php

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $orders = DB::table('orders')->select('id')->pluck('id');

        if ($orders->isEmpty()) {
            return;
        }

        $services = DB::table('services')->select('id', 'price')->get();

        if ($services->isEmpty()) {
            return;
        }

        $chunkSize = 2000;
        $items     = [];
        $now       = CarbonImmutable::now();

        foreach ($orders as $orderId) {

            $perOrder = rand(2,4);

            for ($i = 0; $i < $perOrder; $i++) {

                $service = $services->random();

                $items[] = [
                    'order_id'   => $orderId,
                    'service_id' => $service->id,
                    'price'      => $service->price,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (count($items) === $chunkSize) {
                    DB::table('items')->insert($items);
                    $items = [];
                }
            }
        }

        if (!empty($items)) {
            DB::table('items')->insert($items);
        }

    }
}
