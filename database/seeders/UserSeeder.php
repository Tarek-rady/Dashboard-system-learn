<?php

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{

    public function run(): void
    {


        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $fake       = Factory::create();
        $totalUsers = 100;
        $chunkSize  = 2000;

        $perMonth = intdiv($totalUsers, 12);


        $createdAt = CarbonImmutable::now();
        $users = [];

            for ($i = 0; $i < $totalUsers; $i++) {
                $users[] = [
                    'name'              => $fake->name(),
                    'email'             => $fake->unique()->email(),
                    'phone'             => '010' . $fake->unique()->numberBetween('1000000' , 9999999),
                    'img'               => null,
                    'email_verified_at' => $createdAt,
                    'password'          => bcrypt('password'),
                    'fcm_token'         => Str::random(32),
                    'remember_token'    => Str::random(10),
                    'created_at'        => $createdAt,
                ];

                if(count($users) >= $chunkSize){
                    DB::table('users')->insert($users);
                    $users = [];
                }
            }


            if(!empty($users)){
               DB::table('users')->insert($users);
            }
    }





}
