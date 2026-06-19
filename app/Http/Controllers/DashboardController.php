<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total' => \App\Models\ShippingPlan::count(),
            'waiting_invoice' => \App\Models\ShippingPlan::where('status', 'waiting_invoice')->count(),
            'waiting_packing_list' => \App\Models\ShippingPlan::where('status', 'waiting_packing_list')->count(),
            'ready_for_booking' => \App\Models\ShippingPlan::where('status', 'ready_for_booking')->count(),
            'booked' => \App\Models\ShippingPlan::where('status', 'booked')->count(),
        ];

        $shippingPlans = \App\Models\ShippingPlan::with(['invoice', 'packingList', 'booking', 'creator'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'shippingPlans'));
    }

    public function archive(Request $request)
    {
        $query = \App\Models\ShippingPlan::with(['invoice', 'packingList', 'booking', 'creator'])->latest();

        // Optional search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('invoice', function($inv) use ($search) {
                      $inv->where('invoice_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('packingList', function($pl) use ($search) {
                      $pl->where('packing_list_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('booking', function($bk) use ($search) {
                      $bk->where('booking_number', 'like', "%{$search}%");
                  });
            });
        }

        $shippingPlans = $query->get();

        return view('document-archive', compact('shippingPlans'));
    }
}
