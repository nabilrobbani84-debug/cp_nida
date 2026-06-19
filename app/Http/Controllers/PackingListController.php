<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackingListController extends Controller
{
    public function index()
    {
        $shippingPlans = \App\Models\ShippingPlan::with('packingList', 'invoice', 'creator')->latest()->get();
        return view('packing-lists.index', compact('shippingPlans'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $planId = $request->get('shipping_plan_id');
        $plan = \App\Models\ShippingPlan::findOrFail($planId);
        
        if ($plan->packingList) {
            return redirect()->route('packing-lists.index')->with('error', 'Packing List sudah dibuat untuk Rencana Kirim ini.');
        }

        return view('packing-lists.create', compact('plan'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'shipping_plan_id' => 'required|exists:shipping_plans,id',
            'packing_list_number' => 'required|string|unique:packing_lists',
            'packaging_details' => 'required|string',
            'weight' => 'required|numeric|min:0.01',
            'dimensions' => 'required|string',
        ]);

        $plan = \App\Models\ShippingPlan::findOrFail($request->shipping_plan_id);

        \App\Models\PackingList::create([
            'shipping_plan_id' => $plan->id,
            'packing_list_number' => $request->packing_list_number,
            'packaging_details' => $request->packaging_details,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'created_by' => $request->user()->id,
        ]);

        if ($plan->invoice) {
            $plan->update(['status' => 'ready_for_booking']);
        } else {
            $plan->update(['status' => 'waiting_invoice']);
        }

        return redirect()->route('packing-lists.index')->with('success', 'Packing List Gudang berhasil ditambahkan.');
    }
}
