<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        $productTypes = [
            'Pengecoran Logam (Investment Casting & Sand Casting)',
            'Valve (Katup Industri)',
            'Permanent Mould',
            'Pemesinan (Machining)',
        ];

        foreach ($productTypes as $name) {
            ProductType::query()->firstOrCreate(['name' => $name]);
        }
    }
}
