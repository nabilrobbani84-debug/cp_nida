@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Packing List Gudang</h3>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-0 pb-0">
                <h5 class="mb-0">Daftar PO & Packing List</h5>
                <a href="{{ route('packing-lists.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Tambah Packing List</a>
            </div>
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
                            <th>Packing List Number</th>
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
                                @if($plan->packingList)
                                    <div><strong>{{ $plan->packingList->packing_list_number }}</strong></div>
                                    <div class="text-muted" style="font-size: 0.85rem; line-height: 1.2;">
                                        <strong>Total Berat:</strong> {{ $plan->packingList->weight }} kg <br>
                                        <button class="btn btn-sm btn-link text-info p-0 mt-1 border-0" style="font-size:0.8rem;" type="button" data-bs-toggle="collapse" data-bs-target="#pl-items-{{ $plan->id }}">
                                            <i class="bi bi-eye"></i> Detail ({{ $plan->packingList->items->count() }} Item)
                                        </button>
                                        <div class="collapse mt-2" id="pl-items-{{ $plan->id }}">
                                            <div class="card card-body p-2 border-0 bg-light-secondary shadow-none" style="font-size: 0.8rem; border-radius: 8px;">
                                                @foreach($plan->packingList->items as $item)
                                                    <div class="border-bottom pb-1 mb-1 text-dark">
                                                        <strong>PO/Order:</strong> {{ $item->order_number }}<br>
                                                        <strong>Desc:</strong> {{ $item->description }}<br>
                                                        <strong>Qty:</strong> {{ $item->quantity }} Pcs | 
                                                        <strong>Berat:</strong> {{ $item->net_weight }} kg <br>
                                                        @if($item->length || $item->width || $item->height)
                                                            <strong>Dim:</strong> {{ $item->length ?? 0 }}x{{ $item->width ?? 0 }}x{{ $item->height ?? 0 }} cm
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                @if(!$plan->packingList)
                                    <a href="{{ route('packing-lists.create', ['shipping_plan_id' => $plan->id]) }}" class="btn btn-sm btn-primary">Input Packing List</a>
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
