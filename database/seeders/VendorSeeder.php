<?php

namespace Database\Seeders;

use App\Models\Service;
use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $fake         = Factory::create();
        $totalVendors = 20000;
        $chunkSize    = 2000;

        $startDate = CarbonImmutable::now();
        $vendors = [];

        for ($i = 1; $i <= $totalVendors; $i++) {

            $createdAt = $startDate->addMonths(rand(1, 12));

            $vendors[] = [
                'name'       => "Vendor {$i}",
                'email'      => "vendor{$i}@example.com",
                'phone'      => "010" . str_pad($i, 7, '0', STR_PAD_LEFT),
                'img'        => null,
                'email_verified_at' => $createdAt,
                'password'   => 'password',
                'fcm_token'  => Str::random(32),
                'type'       =>1 ,
                'is_active'  => 1 ,
                'lat'               => '30.9421611' ,
                'lng'               => '31.2950298' ,
                'location'          => 'اجا-الدقهليه' ,
                'remember_token' => Str::random(10),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if (count($vendors) >= $chunkSize) {
                DB::table('vendors')->insert($vendors);
                $vendors = [];
            }
        }

        if (!empty($vendors)) {
            DB::table('vendors')->insert($vendors);
        }


    }
}
