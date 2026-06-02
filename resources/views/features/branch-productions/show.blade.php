@extends('layouts.app')

@section('title', 'Detail Produksi')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row align-items-center flex-md-row flex-column-reverse">
                <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <a href="{{ route('branch-productions.index') }}"
                        class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-chevron-left" style="line-height: 0;"></i>
                    </a>
                    <h3 class="mb-0">Detail Produksi</h3>
                </div>
                <div class="col-12 col-md-6 mt-md-0 mb-md-0 mb-4 mt-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end float-md-end float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('branch-productions.index') }}">Riwayat Produksi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Tanggal Produksi</h6>
                            <p class="fs-6 mb-0">{{ $production->production_date?->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Cabang</h6>
                            <p class="fs-6 mb-0">{{ $production->branch?->branch_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Produk</h6>
                            <p class="fs-6 mb-0">{{ $production->product?->code }} — {{ $production->product?->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Status</h6>
                            <p class="fs-6 mb-0">
                                @include('features.branch-productions.partials.status-badge', [
                                    'status' => $production->status,
                                ])
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Jumlah Lolos QC</h6>
                            <p class="fs-6 mb-0">{{ number_format($production->good_products) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Jumlah Cacat</h6>
                            <p class="fs-6 mb-0">{{ number_format($production->rejected_products) }}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="fw-bold text-muted">Catatan</h6>
                            <p class="fs-6 mb-0">{{ $production->notes ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <a href="{{ route('branch-productions.index') }}" class="btn btn-light-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
