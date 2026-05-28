<?php

use App\Enums\RoleType;

$superAdminOnly = [RoleType::SuperAdmin->value];

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

        // ── Manajemen pengguna (Super Admin) ────────────────────────
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