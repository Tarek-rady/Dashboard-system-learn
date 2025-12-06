<?php

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

     public function run(): void
    {

        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $total = 100;
        $chunkSize = 2000;
        $fake = Factory::create();
        $now = CarbonImmutable::now();

        $rows = [];

        for ($i=1; $i < $total ; $i++) {
            $createdAt = $now->addMonths(rand(1,12));


            $rows [] = [
                'name' => "Tag $i" ,
                'created_at' => $createdAt
            ];


            if(count($rows) >= $chunkSize){
                DB::table('tags')->insert($rows);
            }


        }

        if(!empty($rows)){
           DB::table('tags')->insert($rows);
        }



    }
}
