<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackingListController extends Controller
{
    public function index()
    {
        $shippingPlans = \App\Models\ShippingPlan::with(['packingList.items', 'invoice', 'creator'])->latest()->get();
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
        $data = $request->all();
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as &$item) {
                $item['length'] = (isset($item['length']) && $item['length'] !== '') ? floatval($item['length']) : null;
                $item['width'] = (isset($item['width']) && $item['width'] !== '') ? floatval($item['width']) : null;
                $item['height'] = (isset($item['height']) && $item['height'] !== '') ? floatval($item['height']) : null;
                $item['gross_weight'] = isset($item['gross_weight']) ? floatval($item['gross_weight']) : 0;
                $item['net_weight'] = isset($item['net_weight']) ? floatval($item['net_weight']) : 0;
                $item['quantity'] = isset($item['quantity']) ? intval($item['quantity']) : 1;
            }
        }
        $request->merge($data);

        $request->validate([
            'shipping_plan_id' => 'required|exists:shipping_plans,id',
            'packing_list_number' => 'required|string|unique:packing_lists',
            'items' => 'required|array|min:1',
            'items.*.order_number' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.length' => 'nullable|numeric',
            'items.*.width' => 'nullable|numeric',
            'items.*.height' => 'nullable|numeric',
            'items.*.gross_weight' => 'required|numeric|min:0',
            'items.*.net_weight' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $plan = \App\Models\ShippingPlan::findOrFail($request->shipping_plan_id);

        $totalWeight = 0;
        $totalGrossWeight = 0;
        $totalQty = 0;
        
        foreach ($request->items as $item) {
            $totalWeight += floatval($item['net_weight']);
            $totalGrossWeight += floatval($item['gross_weight']);
            $totalQty += intval($item['quantity']);
        }

        $packingList = \App\Models\PackingList::create([
            'shipping_plan_id' => $plan->id,
            'packing_list_number' => $request->packing_list_number,
            'packaging_details' => "Total Qty: " . $totalQty . " Pcs",
            'weight' => $totalWeight,
            'dimensions' => "Multiple Items",
            'created_by' => $request->user()->id,
        ]);

        foreach ($request->items as $itemData) {
            $packingList->items()->create($itemData);
        }

        if ($plan->invoice) {
            $plan->update(['status' => 'ready_for_booking']);
        } else {
            $plan->update(['status' => 'waiting_invoice']);
        }

        return redirect()->route('packing-lists.index')->with('success', 'Packing List Gudang berhasil ditambahkan.');
    }
}
