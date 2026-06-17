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
                'name' => 'User PPC',
                'email' => 'ppc@example.com',
                'password' => 'password',
                'role' => RoleType::DivisiPPC,
                'branch_name' => null,
            ],
            [
                'name' => 'User Ekspor',
                'email' => 'ekspor@example.com',
                'password' => 'password',
                'role' => RoleType::DivisiEkspor,
                'branch_name' => null,
            ],
            [
                'name' => 'User Gudang',
                'email' => 'gudang@example.com',
                'password' => 'password',
                'role' => RoleType::DivisiGudang,
                'branch_name' => 'Pusat',
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