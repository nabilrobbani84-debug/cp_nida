<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleType::cases() as $roleType) {
            Role::query()->updateOrCreate(
                ['id_role' => $roleType->value],
                ['role_name' => $roleType->label()]
            );
        }
    }
}

