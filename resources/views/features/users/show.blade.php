@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row align-items-center flex-md-row flex-column-reverse">
                <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <!-- Tombol Back Minimalis dengan Chevron -->
                    <a href="{{ route('users.index') }}"
                        class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-chevron-left" style="line-height: 0;"></i>
                    </a>
                    <h3 class="mb-0">Detail Pengguna</h3>
                </div>
                <div class="col-12 col-md-6 mt-md-0 mb-md-0 mb-4 mt-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end float-md-end float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
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
                            <h6 class="fw-bold text-muted">Nama Lengkap</h6>
                            <p class="fs-6 mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Email</h6>
                            <p class="fs-6 mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Dibuat pada</h6>
                            <p class="fs-6 mb-0">{{ $user->created_at?->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Diperbarui pada</h6>
                            <p class="fs-6 mb-0">{{ $user->updated_at?->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
