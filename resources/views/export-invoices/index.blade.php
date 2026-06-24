@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Invoice Ekspor</h3>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Tanggal Kirim</th>
                            <th>Status Rencana</th>
                            <th>Invoice Number</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shippingPlans as $plan)
                        <tr>
                            <td>{{ $plan->po_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</td>
                            <td>
                                @if($plan->status == 'waiting_invoice')
                                    <span class="badge bg-warning">Menunggu Invoice</span>
                                @elseif($plan->status == 'waiting_packing_list')
                                    <span class="badge bg-info">Menunggu Packing List</span>
                                @elseif($plan->status == 'ready_for_booking')
                                    <span class="badge bg-primary">Siap Booking</span>
                                @elseif($plan->status == 'booked')
                                    <span class="badge bg-success">Booked</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->invoice)
                                    <div><strong>{{ $plan->invoice->invoice_number }}</strong></div>
                                    <div class="text-muted" style="font-size: 0.85rem; line-height: 1.2;">
                                        <small>{{ \Carbon\Carbon::parse($plan->invoice->invoice_date)->format('d M Y') }}</small><br>
                                        <button class="btn btn-sm btn-link text-info p-0 mt-1 border-0" style="font-size:0.8rem;" type="button" data-bs-toggle="collapse" data-bs-target="#inv-items-{{ $plan->id }}">
                                            <i class="bi bi-eye"></i> Detail ({{ $plan->invoice->items->count() }} Item)
                                        </button>
                                        <div class="collapse mt-2" id="inv-items-{{ $plan->id }}">
                                            <div class="card card-body p-2 border-0 bg-light-secondary shadow-none" style="font-size: 0.8rem; border-radius: 8px; max-width: 320px;">
                                                @foreach($plan->invoice->items as $item)
                                                    <div class="border-bottom pb-1 mb-1 text-dark">
                                                        <strong>PO:</strong> {{ $item->po_no }} ({{ \Carbon\Carbon::parse($item->po_dated)->format('d/m/Y') }})<br>
                                                        <strong>Desc:</strong> {{ $item->description }}<br>
                                                        <strong>Qty:</strong> {{ $item->quantity }} Pcs<br>
                                                        <strong>Price:</strong> €{{ number_format($item->basic_price, 2) }}<br>
                                                        @if($item->material_surcharge > 0)
                                                            <strong>Surcharge:</strong> €{{ number_format($item->material_surcharge, 2) }}<br>
                                                        @endif
                                                        <strong>Amount:</strong> €{{ number_format($item->amount, 2) }}
                                                    </div>
                                                @endforeach
                                                <div class="pt-1 fw-bold text-primary">
                                                    Total: €{{ number_format($plan->invoice->items->sum('amount'), 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                @if(!$plan->invoice)
                                    <a href="{{ route('export-invoices.create', ['shipping_plan_id' => $plan->id]) }}" class="btn btn-sm btn-primary">Buat Invoice</a>
                                @else
                                    <button class="btn btn-sm btn-success" disabled>Selesai</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
