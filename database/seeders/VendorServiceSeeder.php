<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorServiceSeeder extends Seeder
{

    public function run(): void
    {


        DB::disableQueryLog();
        Model::unsetEventDispatcher();


        $vendorIds = DB::table('vendors')->pluck('id')->all();

        $serviceIds = DB::table('services')->pluck('id')->all();

        $relationRows = [];
        $chunkSize = 5000;

        foreach ($vendorIds as $vendorId) {

            $selected = array_rand($serviceIds, 10);

            foreach ($selected as $index) {
                $relationRows[] = [
                    'vendor_id'  => $vendorId,
                    'service_id' => $serviceIds[$index],
                    'created_at' => now(),
                ];
            }

            if (count($relationRows) >= $chunkSize) {
                DB::table('vendor_services')->insert($relationRows);
                $relationRows = [];
            }
        }

        if (!empty($relationRows)) {
            DB::table('vendor_services')->insert($relationRows);
        }
    }
}
