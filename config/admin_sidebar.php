<?php

use App\Enums\RoleType;

$superAdminOnly = [RoleType::SuperAdmin->value];
$operatorProduksiOnly = [RoleType::OperatorProduksi->value];
$kepalaCabangOnly = [RoleType::KepalaCabang->value];
$productionHistoryRoles = [
    RoleType::OperatorProduksi->value,
    RoleType::KepalaCabang->value,
];
$adminPusatOnly = [RoleType::AdminPusat->value];

return [
    /*
    |--------------------------------------------------------------------------
    | Menu sidebar admin (Mazer)
    |--------------------------------------------------------------------------
    |
    | Struktur datar per baris:
    |   1. ['section' => 'Judul Grup']  — judul section (auto-hide jika kosong)
    |   2. Item menu (label, icon, route|url, active?, role_ids?, children?)
    |
    | role_ids — id_role dari RoleType; kosong/tidak diisi = semua role boleh lihat
    | children — submenu; tiap child: label, route|url, role_ids? (tanpa icon)
    |
    */
    'menu' => [
        // ── Menu utama ──────────────────────────────────────────────
        ['section' => 'Menu'],
        [
            'label' => 'Dashboard',
            'icon' => 'bi bi-grid-fill',
            'route' => 'dashboard',
        ],

        // ── Manajemen Pengguna (Super Admin) ────────────────────────────────
        ['section' => 'Manajemen Pengguna'],
        [
            'label' => 'Pengguna',
            'icon' => 'bi bi-people-fill',
            'route' => 'users.index',
            'active' => 'users.*',
            'role_ids' => $superAdminOnly,
        ],
        [
            'label' => 'Roles',
            'icon' => 'bi bi-shield-lock-fill',
            'route' => 'roles.index',
            'active' => 'roles.*',
            'role_ids' => $superAdminOnly,
        ],

        // ── Master Data (Super Admin) ────────────────────────────────
        ['section' => 'Master Data'],
        [
            'label' => 'Cabang',
            'icon' => 'bi bi-building',
            'route' => 'branches.index',
            'active' => 'branches.*',
            'role_ids' => $superAdminOnly,
        ],
        [
            'label' => 'Jenis Produk',
            'icon' => 'bi bi-box-seam',
            'route' => 'product-types.index',
            'active' => 'product-types.*',
            'role_ids' => $superAdminOnly,
        ],
        [
            'label' => 'Unit',
            'icon' => 'bi bi-rulers',
            'route' => 'units.index',
            'active' => 'units.*',
            'role_ids' => $superAdminOnly,
        ],
        [
            'label' => 'Produk',
            'icon' => 'bi bi-box2-fill',
            'route' => 'products.index',
            'active' => 'products.*',
            'role_ids' => $superAdminOnly,
        ],

        // ── Verifikasi (Admin Pusat) ────────────────────────────────
        ['section' => 'Verifikasi Pusat'],
        [
            'label' => 'Verifikasi Produksi',
            'icon' => 'bi bi-patch-check-fill',
            'route' => 'branch-production-verifications.index',
            'active' => 'branch-production-verifications.*',
            'role_ids' => $adminPusatOnly,
        ],

        // ── Produksi (Operator & Kepala Cabang) ─────────────────────
        ['section' => 'Produksi'],
        [
            'label' => 'Input Produksi Harian',
            'icon' => 'bi bi-clipboard-plus',
            'route' => 'branch-productions.create',
            'active' => 'branch-productions.create',
            'role_ids' => $operatorProduksiOnly,
        ],
        [
            'label' => 'Riwayat Produksi',
            'icon' => 'bi bi-clock-history',
            'route' => 'branch-productions.index',
            'active' => ['branch-productions.index', 'branch-productions.show'],
            'role_ids' => $productionHistoryRoles,
        ],

        // ── Machining (submenu) ─────────────────────────────────────
        // [
        //     'label' => 'Machining',
        //     'icon' => 'bi bi-stack',
        //     'active' => 'machining.*',
        //     'children' => [
        //         ['label' => 'Monitoring', 'route' => 'machining.monitoring.index'],
        //         ['label' => 'Product', 'url' => '#'],
        //         ['label' => 'Process', 'url' => '#'],
        //         ['label' => 'History', 'url' => '#'],
        //     ],
        // ],
    ],
];