<?php

use App\Enums\RoleType;

$divisiPPCOnly = [RoleType::DivisiPPC->value];
$divisiEksporOnly = [RoleType::DivisiEkspor->value];
$divisiGudangOnly = [RoleType::DivisiGudang->value];

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

        // ── Divisi PPC ──────────────────────────────────────────────
        ['section' => 'Divisi PPC'],
        [
            'label' => 'Rencana Kirim',
            'icon' => 'bi bi-calendar-event',
            'route' => 'shipping-plans.index',
            'active' => 'shipping-plans.*',
            'role_ids' => $divisiPPCOnly,
        ],

        // ── Divisi Gudang ───────────────────────────────────────────
        ['section' => 'Divisi Gudang'],
        [
            'label' => 'Packing List',
            'icon' => 'bi bi-box-seam',
            'route' => 'packing-lists.index',
            'active' => 'packing-lists.*',
            'role_ids' => $divisiGudangOnly,
        ],

        // ── Divisi Ekspor ───────────────────────────────────────────
        ['section' => 'Divisi Ekspor'],
        [
            'label' => 'Invoice Ekspor',
            'icon' => 'bi bi-receipt',
            'route' => 'export-invoices.index',
            'active' => 'export-invoices.*',
            'role_ids' => $divisiEksporOnly,
        ],
        [
            'label' => 'Booking Kapal',
            'icon' => 'bi bi-ship',
            'route' => 'vessel-bookings.index',
            'active' => 'vessel-bookings.*',
            'role_ids' => $divisiEksporOnly,
        ],
    ],
];