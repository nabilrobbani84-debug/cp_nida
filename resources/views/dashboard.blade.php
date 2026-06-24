@extends('layouts.app')

@section('title', 'Dashboard Pemantauan Ekspor')

@section('content')
<div class="page-heading mb-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h3 class="fs-4 fs-md-3 fw-bold text-dark mb-1">Dashboard Pemantauan Ekspor</h3>
            <p class="text-subtitle text-muted mb-0" style="font-size: 0.9rem;">Pemantauan Status Kesiapan Dokumen Ekspor Real-Time</p>
        </div>
        <div>
            <span class="badge bg-light-primary p-2 fs-7 fw-semibold">
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
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-indigo mb-4">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.8rem; letter-spacing: 0.02em;">Total Rencana Kirim</h6>
                                    <h3 class="font-extrabold mb-0 text-dark fs-4 fs-md-3">{{ $stats['total'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-primary" style="width: 48px; height: 48px; min-width: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(79, 70, 229, 0.08) !important;">
                                    <i class="bi bi-calendar-event text-primary fs-4" style="color: #4f46e5 !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-warning mb-4">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.8rem; letter-spacing: 0.02em;">Menunggu Invoice</h6>
                                    <h3 class="font-extrabold mb-0 text-warning fs-4 fs-md-3">{{ $stats['waiting_invoice'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-warning" style="width: 48px; height: 48px; min-width: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(245, 158, 11, 0.08) !important;">
                                    <i class="bi bi-receipt text-warning fs-4" style="color: #d97706 !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-info mb-4">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.8rem; letter-spacing: 0.02em;">Menunggu Packing List</h6>
                                    <h3 class="font-extrabold mb-0 text-info fs-4 fs-md-3">{{ $stats['waiting_packing_list'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-info" style="width: 48px; height: 48px; min-width: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(59, 130, 246, 0.08) !important;">
                                    <i class="bi bi-box-seam text-info fs-4" style="color: #2563eb !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-success mb-4">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.8rem; letter-spacing: 0.02em;">Selesai Booking</h6>
                                    <h3 class="font-extrabold mb-0 text-success fs-4 fs-md-3">{{ $stats['booked'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-success" style="width: 48px; height: 48px; min-width: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(16, 185, 129, 0.08) !important;">
                                    <i class="bi bi-ship text-success fs-4" style="color: #059669 !important;"></i>
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
                    <h4 class="mb-0 text-dark fw-bold">Aktivitas & Kesiapan Dokumen Terbaru</h4>
                    <span class="badge bg-primary px-3 py-2">{{ $shippingPlans->count() }} Teratas</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
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
                                            <div class="avatar avatar-md bg-light-secondary me-3" style="width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background-color: rgba(79, 70, 229, 0.05) !important;">
                                                <i class="bi bi-file-earmark-text text-primary fs-5" style="color: #4f46e5 !important;"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-bold mb-0 text-dark">{{ $plan->po_number }}</h6>
                                                <small class="text-muted" style="font-size: 0.75rem;">Oleh: {{ $plan->creator->name ?? 'System' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</span>
                                    </td>
                                    <!-- Status Invoice -->
                                    <td class="text-center">
                                        @if($plan->invoice)
                                            <span class="badge bg-success" data-bs-toggle="tooltip" title="No: {{ $plan->invoice->invoice_number }}">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ $plan->invoice->invoice_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Packing List -->
                                    <td class="text-center">
                                        @if($plan->packingList)
                                            <span class="badge bg-success" data-bs-toggle="tooltip" title="No: {{ $plan->packingList->packing_list_number }}">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ $plan->packingList->packing_list_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Vessel Booking -->
                                    <td class="text-center">
                                        @if($plan->booking)
                                            <span class="badge bg-success" data-bs-toggle="tooltip" title="No: {{ $plan->booking->booking_number }}">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ $plan->booking->booking_number }}
                                            </span>
                                        @else
                                            <span class="badge bg-light-danger text-danger py-2">
                                                <i class="bi bi-x-circle me-1"></i> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Status Overall -->
                                    <td>
                                        @if($plan->status == 'waiting_invoice')
                                            <span class="badge bg-warning py-2 w-100 d-block">Menunggu Invoice</span>
                                        @elseif($plan->status == 'waiting_packing_list')
                                            <span class="badge bg-info py-2 w-100 d-block">Menunggu Packing List</span>
                                        @elseif($plan->status == 'ready_for_booking')
                                            <span class="badge bg-primary py-2 w-100 d-block">Siap Booking</span>
                                        @elseif($plan->status == 'booked')
                                            <span class="badge bg-success py-2 w-100 d-block">Selesai Booking</span>
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