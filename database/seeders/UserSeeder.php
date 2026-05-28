<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branch = fn (string $branchName) => Branch::query()->where('branch_name', $branchName)->firstOrFail();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'password',
                'role' => RoleType::SuperAdmin,
                'branch_name' => null,
            ],
            [
                'name' => 'Admin Pusat',
                'email' => 'adminpusat@example.com',
                'password' => 'password',
                'role' => RoleType::AdminPusat,
                'branch_name' => null,
            ],
            [
                'name' => 'Kepala Cabang 1',
                'email' => 'kepalacabang1@example.com',
                'password' => 'password',
                'role' => RoleType::KepalaCabang,
                'branch_name' => 'Cabang 1',
            ],
            [
                'name' => 'Kepala Cabang 2',
                'email' => 'kepalacabang2@example.com',
                'password' => 'password',
                'role' => RoleType::KepalaCabang,
                'branch_name' => 'Cabang 2',
            ],
            [
                'name' => 'Operator Cabang 1',
                'email' => 'operatorcabang1@example.com',
                'password' => 'password',
                'role' => RoleType::OperatorProduksi,
                'branch_name' => 'Cabang 1',
            ],
            [
                'name' => 'Operator Cabang 2',
                'email' => 'operatorcabang2@example.com',
                'password' => 'password',
                'role' => RoleType::OperatorProduksi,
                'branch_name' => 'Cabang 2',
            ],
            [
                'name' => 'Tim Ekspor',
                'email' => 'timekspor@example.com',
                'password' => 'password',
                'role' => RoleType::TimEkspor,
                'branch_name' => null,
            ],
        ];

        foreach ($users as $u) {
            $branchRow = $u['branch_name'] ? $branch($u['branch_name']) : null;

            User::query()->updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']),
                    'id_role' => $u['role']->value,
                    'id_branch' => $branchRow?->getAttribute('id_branch'),
                ]
            );
        }
    }
}