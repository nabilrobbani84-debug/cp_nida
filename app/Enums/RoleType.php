<?php

namespace App\Enums;

/**
 * ID role tetap — dipakai untuk RBAC & menu sidebar.
 * Ubah label di label() / seeder; jangan ubah nilai enum tanpa migrasi data.
 */
enum RoleType: int
{
    case DivisiPPC = 1;
    case DivisiEkspor = 2;
    case DivisiGudang = 3;

    public function label(): string
    {
        return match ($this) {
            self::DivisiPPC => 'Divisi PPC',
            self::DivisiEkspor => 'Divisi Ekspor',
            self::DivisiGudang => 'Divisi Gudang',
        };
    }

    public static function tryFromId(?int $id): ?self
    {
        return $id === null ? null : self::tryFrom($id);
    }
}
