<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productType = fn (string $name) => ProductType::query()->where('name', $name)->firstOrFail();
        $unit = fn (string $name) => Unit::query()->where('name', $name)->firstOrFail();

        $products = [
            [
                'code' => 'PRD-001',
                'name' => 'Valve Body Casting',
                'product_type_name' => 'Valve (Katup Industri)',
                'unit_name' => 'Pcs',
                'hs_code' => '8481.80.90',
            ],
            [
                'code' => 'PRD-002',
                'name' => 'Impeller Sand Cast',
                'product_type_name' => 'Pengecoran Logam (Investment Casting & Sand Casting)',
                'unit_name' => 'Kg',
                'hs_code' => '8413.91.00',
            ],
            [
                'code' => 'PRD-003',
                'name' => 'Housing Permanent Mould',
                'product_type_name' => 'Permanent Mould',
                'unit_name' => 'Set',
                'hs_code' => '8413.91.00',
            ],
            [
                'code' => 'PRD-004',
                'name' => 'Gate Valve Machined',
                'product_type_name' => 'Pemesinan (Machining)',
                'unit_name' => 'Pcs',
                'hs_code' => '8481.80.10',
            ],
            [
                'code' => 'PRD-005',
                'name' => 'Investment Cast Bracket',
                'product_type_name' => 'Pengecoran Logam (Investment Casting & Sand Casting)',
                'unit_name' => 'Box',
                'hs_code' => '7325.99.00',
            ],
            [
                'code' => 'PRD-006',
                'name' => 'Industrial Valve Assembly',
                'product_type_name' => 'Valve (Katup Industri)',
                'unit_name' => 'Set',
                'hs_code' => '8481.80.90',
            ],
        ];

        foreach ($products as $item) {
            Product::query()->updateOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'id_product_type' => $productType($item['product_type_name'])->id_product_type,
                    'id_unit' => $unit($item['unit_name'])->id_unit,
                    'hs_code' => $item['hs_code'],
                ]
            );
        }
    }
}