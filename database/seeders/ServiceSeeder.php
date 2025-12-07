<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        $categoryIds = Category::pluck('id')->all();
        if (empty($categoryIds)) return;

        $now = CarbonImmutable::now();

        $services = [
            'Cleaning Service',
            'Home Painting',
            'Electric Repair',
            'Plumbing Fix',
            'Deep Cleaning',
            'Garden Maintenance',
            'Air Conditioner Repair',
            'Furniture Assembly',
            'Water Tank Cleaning',
            'Pest Control'
        ];

        $rows = [];

        foreach ($services as $serviceName) {

            $rows[] = [
                'name'        => $serviceName,
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'price'       => rand(50, 300),
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        DB::table('services')->insert($rows);
    }
}
