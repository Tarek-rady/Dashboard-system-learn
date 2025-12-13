<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $users = User::select('id')->orderBy('id')->limit(2)->get();



        $faker      = Factory::create('ar_EG');
        $chunkSize  = 2000;
        $perUser    = 100000;

        foreach ($users as $user) {


            $orders = [];

            for ($i = 1; $i <= $perUser; $i++) {

                $cost     = rand(100, 5000);
                $discount = rand(0, 1) ? rand(10, 300) : 0;
                $tax      = round($cost * 0.14, 2);
                $total    = $cost - $discount + $tax;

                $date = CarbonImmutable::now()
                    ->subDays(rand(0, 365))
                    ->subMinutes(rand(0, 1440));


                    $now = now()->subMonth(rand(1,10));

                $orders[] = [
                    'user_id'        => $user->id,
                    'vendor_id'      => rand(1, 9),
                    'status'         => rand(1, 4),
                    'code'           => strtoupper(Str::random(12)),
                    'payment'        => rand(1, 7),
                    'date_requested' =>$now,
                    'cost'           => $cost,
                    'total_discount' => $discount,
                    'tax'            => $tax,
                    'total'          => $total,
                    'coupon'         => null,
                    'msg'            => null,
                    'read'           => 0,
                    'time_type'      => rand(1, 2),
                    'res_type'       => rand(1, 2),
                    'date'           => $date->toDateString(),
                    'start_time'     => '12:00',
                    'end_time'       => '14:00',
                    'lat'            => '30.9421611',
                    'lng'            => '31.2950298',
                    'location'       => 'أجا - الدقهلية',
                    'created_at'     =>  $now,
                    'updated_at'     =>  $now,
                ];

                if (count($orders) === $chunkSize) {
                    DB::table('orders')->insert($orders);
                    $orders = [];
                }
            }

            if (!empty($orders)) {
                DB::table('orders')->insert($orders);
            }
        }

    }
}
