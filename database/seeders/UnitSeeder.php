<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            'Pcs',
            'Set',
            'Kg',
            'Box',
        ];

        foreach ($units as $name) {
            Unit::query()->firstOrCreate(['name' => $name]);
        }
    }
}
