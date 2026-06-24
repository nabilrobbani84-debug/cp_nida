<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportInvoiceController extends Controller
{
    public function index()
    {
        // Get shipping plans that are waiting for an invoice or already have one
        $shippingPlans = \App\Models\ShippingPlan::with(['invoice.items', 'creator'])->latest()->get();
        return view('export-invoices.index', compact('shippingPlans'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $planId = $request->get('shipping_plan_id');
        $plan = \App\Models\ShippingPlan::findOrFail($planId);
        
        if ($plan->invoice) {
            return redirect()->route('export-invoices.index')->with('error', 'Invoice sudah dibuat untuk Rencana Kirim ini.');
        }

        return view('export-invoices.create', compact('plan'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'shipping_plan_id' => 'required|exists:shipping_plans,id',
            'invoice_number' => 'required|string|unique:export_invoices',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.po_no' => 'required|string',
            'items.*.po_dated' => 'required|date',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.description' => 'required|string',
            'items.*.basic_price' => 'required|numeric|min:0',
            'items.*.material_surcharge' => 'nullable|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $plan = \App\Models\ShippingPlan::findOrFail($request->shipping_plan_id);

        $invoice = \App\Models\ExportInvoice::create([
            'shipping_plan_id' => $plan->id,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'created_by' => $request->user()->id,
        ]);

        foreach ($request->items as $itemData) {
            $invoice->items()->create($itemData);
        }

        // Update status plan: if packing list exists, maybe it's ready_for_booking
        if ($plan->packingList) {
            $plan->update(['status' => 'ready_for_booking']);
        } else {
            $plan->update(['status' => 'waiting_packing_list']);
        }

        return redirect()->route('export-invoices.index')->with('success', 'Invoice Ekspor berhasil ditambahkan.');
    }
}
