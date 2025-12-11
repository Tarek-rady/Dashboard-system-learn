<?php

namespace App\Console\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class deleteOfferApproved extends Command
{

    protected $signature = 'app:delete-offer-approved';


    protected $description = 'Command description';


    public function handle()
    {

        $time = CarbonImmutable::now()->subMinute();

        DB::table('offers')->select(['id' , 'status'])->where('status' , 1)
                           ->where('created_at' , '<=' , $time)->delete();
    }
}
