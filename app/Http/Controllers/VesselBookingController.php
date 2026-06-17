<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VesselBookingController extends Controller
{
    public function index()
    {
        // Get shipping plans that are ready for booking or already booked
        $shippingPlans = \App\Models\ShippingPlan::with('booking', 'invoice', 'packingList', 'creator')->latest()->get();
        return view('vessel-bookings.index', compact('shippingPlans'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $planId = $request->get('shipping_plan_id');
        $plan = \App\Models\ShippingPlan::findOrFail($planId);
        
        if ($plan->status != 'ready_for_booking') {
            return redirect()->route('vessel-bookings.index')->with('error', 'Rencana Kirim ini belum siap untuk dibooking. Pastikan Invoice dan Packing List sudah lengkap.');
        }
        
        if ($plan->booking) {
            return redirect()->route('vessel-bookings.index')->with('error', 'Booking sudah dibuat untuk Rencana Kirim ini.');
        }

        return view('vessel-bookings.create', compact('plan'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'shipping_plan_id' => 'required|exists:shipping_plans,id',
            'booking_number' => 'required|string|unique:vessel_bookings',
            'booking_date' => 'required|date',
        ]);

        $plan = \App\Models\ShippingPlan::findOrFail($request->shipping_plan_id);

        \App\Models\VesselBooking::create([
            'shipping_plan_id' => $plan->id,
            'booking_number' => $request->booking_number,
            'booking_date' => $request->booking_date,
            'created_by' => $request->user()->id,
        ]);

        $plan->update(['status' => 'booked']);

        return redirect()->route('vessel-bookings.index')->with('success', 'Booking Kapal berhasil ditambahkan.');
    }
}
