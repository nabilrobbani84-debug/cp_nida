@extends('layouts.app')

@section('title', 'Detail Unit')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row align-items-center flex-md-row flex-column-reverse">
                <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <a href="{{ route('units.index') }}"
                        class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-chevron-left" style="line-height: 0;"></i>
                    </a>
                    <h3 class="mb-0">Detail Unit</h3>
                </div>
                <div class="col-12 col-md-6 mt-md-0 mb-md-0 mb-4 mt-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end float-md-end float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Unit</a></li>
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
                            <h6 class="fw-bold text-muted">Nama</h6>
                            <p class="fs-6 mb-0">{{ $unit->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Dibuat pada</h6>
                            <p class="fs-6 mb-0">{{ $unit->created_at?->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Diperbarui pada</h6>
                            <p class="fs-6 mb-0">{{ $unit->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <a href="{{ route('units.index') }}" class="btn btn-light-secondary">Kembali</a>
                        <a href="{{ route('units.edit', $unit) }}" class="btn btn-primary">Ubah</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
