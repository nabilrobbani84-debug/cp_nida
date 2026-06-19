@extends('layouts.app')

@section('title', 'Dashboard Pemantauan Ekspor')

@section('content')
<div class="page-heading">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Dashboard Pemantauan Ekspor</h3>
            <p class="text-subtitle text-muted">Pemantauan Status Kesiapan Dokumen Ekspor Real-Time</p>
        </div>
        <div>
            <span class="badge bg-light-primary p-2">
                <i class="bi bi-clock-history me-1"></i> Terakhir Diperbarui: {{ now()->format('H:i') }} WIB
            </span>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <!-- Statistik Cards -->
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon purple mb-2 me-3" style="width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; background-color: #e8dbff; border-radius: 10px;">
                                    <i class="bi bi-calendar-event text-primary fs-4" style="color: #5a2bee !important;"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted font-semibold">Total Rencana Kirim</h6>
                                    <h5 class="font-extrabold mb-0">{{ $stats['total'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon orange mb-2 me-3" style="width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; background-color: #ffe8d6; border-radius: 10px;">
                                    <i class="bi bi-receipt text-warning fs-4" style="color: #fd7e14 !important;"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted font-semibold">Menunggu Invoice</h6>
                                    <h5 class="font-extrabold mb-0 text-warning">{{ $stats['waiting_invoice'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon blue mb-2 me-3" style="width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; background-color: #d6eaff; border-radius: 10px;">
                                    <i class="bi bi-box-seam text-info fs-4" style="color: #0dcaf0 !important;"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted font-semibold">Menunggu Packing List</h6>
                                    <h5 class="font-extrabold mb-0 text-info">{{ $stats['waiting_packing_list'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body px-4 py-4-5">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon green mb-2 me-3" style="width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center; background-color: #d2f8d2; border-radius: 10px;">
                                    <i class="bi bi-ship text-success fs-4" style="color: #198754 !important;"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted font-semibold">Selesai Booking</h6>
                                    <h5 class="font-extrabold mb-0 text-success">{{ $stats['booked'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Monitoring Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Aktivitas & Kesiapan Dokumen Terbaru</h4>
                    <span class="badge bg-primary">{{ $shippingPlans->count() }} Teratas</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg align-middle">
                            <thead>
                                <tr class="table-light">
                                    <th>Nomor PO (PPC)</th>
                                    <th>Tanggal Kirim</th>
                                    <th class="text-center">Invoice (Ekspor)</th>
                                    <th class="text-center">Packing List (Gudang)</th>
                                    <th class="text-center">Booking (Ekspor)</th>
                                    <th>Status Sistem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shippingPlans as $plan)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md bg-light-secondary me-3" style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <span class="font-bold text-secondary">PO</span>
                                            </div>
                                            <div>
                                                <h6 class="font-bold mb-0 text-primary">{{ $plan->po_number }}</h6>
                                                <small class="text-muted">Dibuat oleh: {{ $plan->creator->name ?? 'System' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-bold">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</span>
                                    </td>
                                    <!-- Status Invoice -->
                                    <td class="text-center">
                                        @if($plan->invoice)
                                            <span class="badge bg-success py-2 px-3" data-bs-toggle="tooltip" title="No: {{ $plan->invoice->invoice_number }}">
                                                <i class="bi bi-check-circle me-1"></i> {{ $plan->invoice->invoice_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2 px-3">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Packing List -->
                                    <td class="text-center">
                                        @if($plan->packingList)
                                            <span class="badge bg-success py-2 px-3" data-bs-toggle="tooltip" title="No: {{ $plan->packingList->packing_list_number }}">
                                                <i class="bi bi-check-circle me-1"></i> {{ $plan->packingList->packing_list_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2 px-3">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Vessel Booking -->
                                    <td class="text-center">
                                        @if($plan->booking)
                                            <span class="badge bg-success py-2 px-3" data-bs-toggle="tooltip" title="No: {{ $plan->booking->booking_number }}">
                                                <i class="bi bi-check-circle me-1"></i> {{ $plan->booking->booking_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2 px-3">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Overall -->
                                    <td>
                                        @if($plan->status == 'waiting_invoice')
                                            <span class="badge bg-warning py-2 px-3 w-100">Menunggu Invoice</span>
                                        @elseif($plan->status == 'waiting_packing_list')
                                            <span class="badge bg-info py-2 px-3 w-100">Menunggu Packing List</span>
                                        @elseif($plan->status == 'ready_for_booking')
                                            <span class="badge bg-primary py-2 px-3 w-100">Siap Booking</span>
                                        @elseif($plan->status == 'booked')
                                            <span class="badge bg-success py-2 px-3 w-100">Selesai Booking</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted fs-1 d-block mb-3"></i>
                                        <span class="text-muted">Belum ada data rencana pengiriman aktif.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection