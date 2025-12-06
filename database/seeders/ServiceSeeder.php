<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\CarbonImmutable;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        Model::unsetEventDispatcher();

        $categoryIds = Category::pluck('id')->all();

        $fake      = Factory::create();
        $chunkSize = 1000;
        $rows      = [];
        $now       = CarbonImmutable::now();

        foreach ($categoryIds as $categoryId) {

            $servicesCount = rand(3, 8);

            for ($i = 0; $i < $servicesCount; $i++) {

                $createdAt = $now->addMonths(rand(0, 11));

                $rows[] = [
                    'name'        => 'Service From ' . $categoryId,
                    'category_id' => $categoryId,
                    'price'       => rand(50, 100),
                    'is_active' => rand(0,1) ,
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ];

                if (count($rows) >= $chunkSize) {
                    DB::table('services')->insert($rows);
                    $rows = [];
                }
            }
        }

        if (!empty($rows)) {
            DB::table('services')->insert($rows);
        }
    }
}
