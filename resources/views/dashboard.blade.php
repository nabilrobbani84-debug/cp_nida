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
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-indigo mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.85rem;">Total Rencana Kirim</h6>
                                    <h3 class="font-extrabold mb-0 text-dark">{{ $stats['total'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-primary" style="width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(79, 70, 229, 0.08) !important;">
                                    <i class="bi bi-calendar-event text-primary fs-3" style="color: #4f46e5 !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-warning mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.85rem;">Menunggu Invoice</h6>
                                    <h3 class="font-extrabold mb-0 text-warning">{{ $stats['waiting_invoice'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-warning" style="width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(245, 158, 11, 0.08) !important;">
                                    <i class="bi bi-receipt text-warning fs-3" style="color: #d97706 !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-info mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.85rem;">Menunggu Packing List</h6>
                                    <h3 class="font-extrabold mb-0 text-info">{{ $stats['waiting_packing_list'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-info" style="width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(59, 130, 246, 0.08) !important;">
                                    <i class="bi bi-box-seam text-info fs-3" style="color: #2563eb !important;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 border-start border-4 border-success mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted font-semibold mb-1" style="font-size: 0.85rem;">Selesai Booking</h6>
                                    <h3 class="font-extrabold mb-0 text-success">{{ $stats['booked'] }}</h3>
                                </div>
                                <div class="stats-icon bg-light-success" style="width: 3.5rem; height: 3.5rem; display: flex; align-items: center; justify-content: center; border-radius: 12px; background-color: rgba(16, 185, 129, 0.08) !important;">
                                    <i class="bi bi-ship text-success fs-3" style="color: #059669 !important;"></i>
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