<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Menu sidebar admin (Mazer)
    |--------------------------------------------------------------------------
    |
    | section  — judul grup (sidebar-title)
    | route    — nama route Laravel (prioritas untuk href & active)
    | url      — href manual jika tidak pakai route (misal '#')
    | active   — pola untuk request()->routeIs() pada menu bertsubmenu
    | children — submenu: tiap item pakai route atau url + label
    |
    */
    'menu' => [
        ['section' => 'Menu'],

        [
            'label' => 'Dashboard',
            'icon' => 'bi bi-grid-fill',
            'route' => 'dashboard',
        ],
        [
            'label' => 'standalone menu',
            'icon' => 'bi bi-grid-1x2-fill',
            'url' => '#',
        ],
        [
            'label' => 'Machining',
            'icon' => 'bi bi-stack',
            'active' => 'machining.*',
            'children' => [
                ['label' => 'Monitoring', 'route' => 'machining.monitoring.index'],
                ['label' => 'Product', 'url' => '#'],
                ['label' => 'Process', 'url' => '#'],
                ['label' => 'History', 'url' => '#'],
            ],
        ],
    ],
];