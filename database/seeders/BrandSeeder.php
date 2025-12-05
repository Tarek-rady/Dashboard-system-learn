<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{

    public function run(): void
    {

        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $TOTAL = 100;
        




    }
}
