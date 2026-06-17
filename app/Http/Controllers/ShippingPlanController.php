<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingPlanController extends Controller
{
    public function index()
    {
        $shippingPlans = \App\Models\ShippingPlan::with('creator')->latest()->get();
        return view('shipping-plans.index', compact('shippingPlans'));
    }

    public function create()
    {
        return view('shipping-plans.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'po_number' => 'required|string|unique:shipping_plans',
            'shipping_date' => 'required|date',
        ]);

        \App\Models\ShippingPlan::create([
            'po_number' => $request->po_number,
            'shipping_date' => $request->shipping_date,
            'status' => 'waiting_invoice',
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('shipping-plans.index')->with('success', 'Rencana Kirim berhasil ditambahkan.');
    }
}
