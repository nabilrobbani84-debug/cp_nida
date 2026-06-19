@extends('layouts.app')

@section('title', 'Arsip Dokumen Digital')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Arsip Dokumen Digital</h3>
                <p class="text-subtitle text-muted">Penyimpanan Terpusat Dokumen Ekspor (Invoice, Packing List, & Booking)</p>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card shadow-sm border-0 my-3">
        <div class="card-body">
            <form action="{{ route('document-archive') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nomor PO, Invoice, Packing List, atau Booking Kapal..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter me-1"></i> Cari Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr class="table-light">
                                <th width="15%">Rencana PPC (PO)</th>
                                <th width="25%">Invoice (Ekspor)</th>
                                <th width="30%">Packing List (Gudang)</th>
                                <th width="20%">Booking Kapal (Ekspor)</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shippingPlans as $plan)
                            <tr>
                                <!-- PO Rencana -->
                                <td>
                                    <div class="font-bold text-primary">{{ $plan->po_number }}</div>
                                    <small class="text-muted d-block">Kirim: {{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</small>
                                    <small class="text-muted d-block">Oleh: {{ $plan->creator->name ?? '-' }}</small>
                                </td>

                                <!-- Invoice -->
                                <td>
                                    @if($plan->invoice)
                                        <div class="border rounded p-2 bg-light-success border-success text-success">
                                            <div class="font-bold"><i class="bi bi-file-earmark-text me-1"></i>{{ $plan->invoice->invoice_number }}</div>
                                            <div style="font-size: 0.85rem">Tgl: {{ \Carbon\Carbon::parse($plan->invoice->invoice_date)->format('d M Y') }}</div>
                                            <div style="font-size: 0.8rem" class="text-muted">Oleh: {{ $plan->invoice->creator->name ?? '-' }}</div>
                                        </div>
                                    @else
                                        <div class="border rounded p-2 bg-light-danger border-danger text-danger text-center">
                                            <small><i class="bi bi-exclamation-triangle me-1"></i>Belum Dibuat</small>
                                        </div>
                                    @endif
                                </td>

                                <!-- Packing List -->
                                <td>
                                    @if($plan->packingList)
                                        <div class="border rounded p-2 bg-light-info border-info text-dark">
                                            <div class="font-bold text-info"><i class="bi bi-box-seam me-1"></i>{{ $plan->packingList->packing_list_number }}</div>
                                            <div style="font-size: 0.85rem">
                                                <strong>Kemasan:</strong> {{ $plan->packingList->packaging_details }}<br>
                                                <strong>Berat:</strong> {{ $plan->packingList->weight }} kg<br>
                                                <strong>Dimensi:</strong> {{ $plan->packingList->dimensions }}
                                            </div>
                                            <div style="font-size: 0.8rem" class="text-muted mt-1 border-top pt-1">Oleh: {{ $plan->packingList->creator->name ?? '-' }}</div>
                                        </div>
                                    @else
                                        <div class="border rounded p-2 bg-light-danger border-danger text-danger text-center">
                                            <small><i class="bi bi-exclamation-triangle me-1"></i>Belum Dibuat</small>
                                        </div>
                                    @endif
                                </td>

                                <!-- Booking -->
                                <td>
                                    @if($plan->booking)
                                        <div class="border rounded p-2 bg-light-primary border-primary text-primary">
                                            <div class="font-bold"><i class="bi bi-ship me-1"></i>{{ $plan->booking->booking_number }}</div>
                                            <div style="font-size: 0.85rem">Tgl: {{ \Carbon\Carbon::parse($plan->booking->booking_date)->format('d M Y') }}</div>
                                            <div style="font-size: 0.8rem" class="text-muted">Oleh: {{ $plan->booking->creator->name ?? '-' }}</div>
                                        </div>
                                    @else
                                        <div class="border rounded p-2 bg-light-danger border-danger text-danger text-center">
                                            <small><i class="bi bi-exclamation-triangle me-1"></i>Belum Dibuat</small>
                                        </div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    @if($plan->status == 'waiting_invoice')
                                        <span class="badge bg-warning w-100">Menunggu Invoice</span>
                                    @elseif($plan->status == 'waiting_packing_list')
                                        <span class="badge bg-info w-100">Menunggu Packing</span>
                                    @elseif($plan->status == 'ready_for_booking')
                                        <span class="badge bg-primary w-100">Siap Booking</span>
                                    @elseif($plan->status == 'booked')
                                        <span class="badge bg-success w-100">Booked</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-search text-muted fs-1 d-block mb-3"></i>
                                    <span class="text-muted">Tidak ada arsip dokumen yang cocok dengan pencarian Anda.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
