<?php

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Riyadh' , 'Mecca' , 'Medina'];


        $cities = [];
        $now = CarbonImmutable::now();
        foreach ($names as $key => $value) {

            $cities[] = [
              'name' => $value ,
              'created_at' => $now
            ];


            DB::table('cities')->insert($cities);
        }
    }
}


