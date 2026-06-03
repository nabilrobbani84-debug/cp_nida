<?php

namespace Database\Seeders;

use App\Enums\BranchProductionStatus;
use App\Models\Branch;
use App\Models\BranchProduction;
use App\Models\Product;
use Illuminate\Database\Seeder;

class BranchProductionSeeder extends Seeder
{
    public function run(): void
    {
        $branch = fn (string $name) => Branch::query()->where('branch_name', $name)->firstOrFail();
        $product = fn (string $code) => Product::query()->where('code', $code)->firstOrFail();

        $records = [
            // Pending — untuk halaman verifikasi Admin Pusat
            [
                'production_date' => now()->subDays(1)->toDateString(),
                'branch_name' => 'Cabang 1',
                'product_code' => 'PRD-001',
                'good_products' => 120,
                'rejected_products' => 5,
                'status' => BranchProductionStatus::Pending,
                'notes' => null,
            ],
            [
                'production_date' => now()->subDays(2)->toDateString(),
                'branch_name' => 'Cabang 1',
                'product_code' => 'PRD-002',
                'good_products' => 85,
                'rejected_products' => 12,
                'status' => BranchProductionStatus::Pending,
                'notes' => null,
            ],
            [
                'production_date' => now()->subDays(1)->toDateString(),
                'branch_name' => 'Cabang 2',
                'product_code' => 'PRD-003',
                'good_products' => 200,
                'rejected_products' => 8,
                'status' => BranchProductionStatus::Pending,
                'notes' => null,
            ],
            [
                'production_date' => now()->toDateString(),
                'branch_name' => 'Cabang 2',
                'product_code' => 'PRD-004',
                'good_products' => 45,
                'rejected_products' => 3,
                'status' => BranchProductionStatus::Pending,
                'notes' => null,
            ],
            // Validated & Rejected — untuk uji riwayat operator
            [
                'production_date' => now()->subDays(5)->toDateString(),
                'branch_name' => 'Cabang 1',
                'product_code' => 'PRD-005',
                'good_products' => 60,
                'rejected_products' => 2,
                'status' => BranchProductionStatus::Validated,
                'notes' => null,
            ],
            [
                'production_date' => now()->subDays(4)->toDateString(),
                'branch_name' => 'Cabang 1',
                'product_code' => 'PRD-006',
                'good_products' => 30,
                'rejected_products' => 15,
                'status' => BranchProductionStatus::Rejected,
                'notes' => 'Jumlah cacat terlalu tinggi. Mohon perbaiki proses QC dan input ulang data yang benar.',
            ],
            [
                'production_date' => now()->subDays(3)->toDateString(),
                'branch_name' => 'Cabang 2',
                'product_code' => 'PRD-006',
                'good_products' => 90,
                'rejected_products' => 1,
                'status' => BranchProductionStatus::Validated,
                'notes' => null,
            ],
        ];

        foreach ($records as $item) {
            $branchRow = $branch($item['branch_name']);
            $productRow = $product($item['product_code']);

            BranchProduction::query()->updateOrCreate(
                [
                    'production_date' => $item['production_date'],
                    'id_branch' => $branchRow->id_branch,
                    'id_product' => $productRow->id_product,
                    'status' => $item['status'],
                ],
                [
                    'good_products' => $item['good_products'],
                    'rejected_products' => $item['rejected_products'],
                    'notes' => $item['notes'],
                ]
            );
        }
    }
}