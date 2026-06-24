<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
        ]);

        $ppc = \App\Models\User::where('email', 'ppc@example.com')->first();
        $gudang = \App\Models\User::where('email', 'gudang@example.com')->first();
        $ekspor = \App\Models\User::where('email', 'ekspor@example.com')->first();

        // 1. Create a Shipping Plan (PO)
        $plan = \App\Models\ShippingPlan::create([
            'po_number' => 'PO-180006520',
            'shipping_date' => '2026-07-25',
            'status' => 'booked',
            'created_by' => $ppc->id,
        ]);

        // 2. Create Invoice
        \App\Models\ExportInvoice::create([
            'shipping_plan_id' => $plan->id,
            'invoice_number' => 'INV-180006520',
            'invoice_date' => '2026-06-20',
            'created_by' => $ekspor->id,
        ]);

        // 3. Create Packing List
        $packingList = \App\Models\PackingList::create([
            'shipping_plan_id' => $plan->id,
            'packing_list_number' => '189/MTC/EX/II/26',
            'packaging_details' => 'Total Qty: 15 Pcs',
            'weight' => 776.0,
            'dimensions' => 'Multiple Items',
            'created_by' => $gudang->id,
        ]);

        // 4. Create Packing List Items from Image
        $items = [
            [
                'order_number' => '180006514 (POS 2)',
                'description' => 'Vane Wheel Impeller RZ72011 (40043546)',
                'length' => 82.0, 'width' => 65.0, 'height' => 78.0,
                'gross_weight' => 20.0, 'net_weight' => 18.0, 'quantity' => 1
            ],
            [
                'order_number' => '180006512 (POS 2)',
                'description' => 'Vane Wheel Impeller 7302M08-113 (Ref: RZ72013) (40043545)',
                'length' => 82.0, 'width' => 65.0, 'height' => 78.0,
                'gross_weight' => 20.0, 'net_weight' => 62.0, 'quantity' => 1
            ],
            [
                'order_number' => '1800024466 (POS 1)',
                'description' => 'Vacuum Casing RZ763-120.031-211 (40023605)',
                'length' => 51.0, 'width' => 65.0, 'height' => 78.0,
                'gross_weight' => 29.0, 'net_weight' => 10.0, 'quantity' => 5
            ],
            [
                'order_number' => '1800023223 (POS 1)',
                'description' => 'Side Channel casing F2431.327.130 (20213747)',
                'length' => 51.0, 'width' => 65.0, 'height' => 78.0,
                'gross_weight' => 29.0, 'net_weight' => 32.0, 'quantity' => 2
            ],
            [
                'order_number' => '1800023224 (POS 1)',
                'description' => 'Bearing Cover 730.225.101-213 (43083433) (4403442)',
                'length' => 100.0, 'width' => 85.0, 'height' => 49.0,
                'gross_weight' => 29.0, 'net_weight' => 236.0, 'quantity' => 1
            ],
            [
                'order_number' => '180006520 (POS 10)',
                'description' => 'Bearing Bracket 3 r.p RZ78513 (48021795)',
                'length' => 98.0, 'width' => 56.0, 'height' => 47.0,
                'gross_weight' => 18.0, 'net_weight' => 138.0, 'quantity' => 2
            ],
            [
                'order_number' => '180006520 (POS 10)',
                'description' => 'Bearing Bracket 2 r.p RZ78513 (43021795)',
                'length' => 98.0, 'width' => 56.0, 'height' => 47.0,
                'gross_weight' => 16.0, 'net_weight' => 158.0, 'quantity' => 2
            ],
            [
                'order_number' => '180006520 (POS 3)',
                'description' => 'Casing r.p RZ 79-46.754453303-2113 (40044528)',
                'length' => 88.0, 'width' => 80.0, 'height' => 58.0,
                'gross_weight' => 24.0, 'net_weight' => 88.0, 'quantity' => 1
            ]
        ];

        foreach ($items as $itemData) {
            $packingList->items()->create($itemData);
        }

        // 5. Create Booking
        \App\Models\VesselBooking::create([
            'shipping_plan_id' => $plan->id,
            'booking_number' => 'BK-180006520',
            'booking_date' => '2026-06-22',
            'created_by' => $ekspor->id,
        ]);

        // Add a second plan that is waiting for data to allow live testing
        \App\Models\ShippingPlan::create([
            'po_number' => 'PO-180007890',
            'shipping_date' => '2026-08-10',
            'status' => 'waiting_invoice',
            'created_by' => $ppc->id,
        ]);
    }
}
