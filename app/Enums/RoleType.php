<?php

namespace App\Enums;

/**
 * ID role tetap — dipakai untuk RBAC & menu sidebar.
 * Ubah label di label() / seeder; jangan ubah nilai enum tanpa migrasi data.
 */
enum RoleType: int
{
    case SuperAdmin = 1;
    case AdminPusat = 2;
    case KepalaCabang = 3;
    case OperatorProduksi = 4;
    case TimEkspor = 5;

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::AdminPusat => 'Admin Pusat',
            self::KepalaCabang => 'Kepala Cabang',
            self::OperatorProduksi => 'Operator Produksi',
            self::TimEkspor => 'Tim Ekspor',
        };
    }

    public static function tryFromId(?int $id): ?self
    {
        return $id === null ? null : self::tryFrom($id);
    }
}
