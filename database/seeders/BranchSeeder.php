<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['branch_name' => 'Pusat', 'location' => 'Kantor Pusat'],
            ['branch_name' => 'Cabang 1', 'location' => 'Pabrik A'],
            ['branch_name' => 'Cabang 2', 'location' => 'Pabrik B'],
        ];

        foreach ($branches as $branch) {
            Branch::query()->firstOrCreate(
                ['branch_name' => $branch['branch_name']],
                ['location' => $branch['location']]
            );
        }
    }
}

