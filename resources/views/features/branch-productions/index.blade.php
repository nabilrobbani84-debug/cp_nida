@extends('layouts.app')

@section('title', 'Riwayat Produksi')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Riwayat Produksi</h3>
                    <p class="text-muted mb-0 small">
                        Cabang: {{ auth()->user()->branch?->branch_name ?? '—' }}
                        @if ($readOnly)
                            <span class="badge bg-light-secondary text-dark ms-1">Mode baca saja</span>
                        @endif
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end mb-md-0 float-start mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Produksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header pb-0">
                    <div
                        class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center justify-content-between gap-3">
                        <form action="{{ route('branch-productions.index') }}" method="get"
                            class="d-flex align-items-center" style="max-width: 100%;">
                            <div class="input-group input-group-sm w-100" style="min-width: 16rem;">
                                <input type="text" name="search" value="{{ $search }}"
                                    class="form-control form-control-sm" placeholder="Cari produk / catatan…"
                                    autocomplete="off">
                                @if ($search !== '')
                                    <a href="{{ route('branch-productions.index') }}" class="btn btn-primary"
                                        title="Hapus Pencarian">&times;</a>
                                @endif
                            </div>
                        </form>
                        @unless ($readOnly)
                            <div class="d-flex align-items-center">
                                <a href="{{ route('branch-productions.create') }}"
                                    class="btn btn-primary btn-sm w-100 w-lg-auto ms-lg-auto">
                                    <i class="bi bi-plus-lg me-1"></i> Input Produksi
                                </a>
                            </div>
                        @endunless
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="d-flex flex-wrap gap-3 mb-3 small">
                        <span>@include('features.branch-productions.partials.status-badge', ['status' => 'pending']) Pending</span>
                        <span>@include('features.branch-productions.partials.status-badge', ['status' => 'validated']) Validated</span>
                        <span>@include('features.branch-productions.partials.status-badge', ['status' => 'rejected']) Rejected</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th class="text-end">Lolos QC</th>
                                    <th class="text-end">Cacat</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 6rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productions as $production)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{ $production->production_date?->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <span class="d-block fw-semibold">{{ $production->product?->name }}</span>
                                            <span class="small text-muted">{{ $production->product?->code }}</span>
                                        </td>
                                        <td class="text-end">{{ number_format($production->good_products) }}</td>
                                        <td class="text-end">{{ number_format($production->rejected_products) }}</td>
                                        <td>
                                            @include('features.branch-productions.partials.status-badge', [
                                                'status' => $production->status,
                                            ])
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('branch-productions.show', $production) }}"
                                                class="btn btn-sm btn-light-warning" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted py-5 text-center">
                                            @if ($search !== '')
                                                Tidak ada hasil untuk "<strong>{{ $search }}</strong>"
                                            @else
                                                Belum ada data produksi.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($productions->total() > 0)
                        <div class="row align-items-center g-2 mt-3">
                            <div class="col-md-6 small text-muted">
                                Menampilkan {{ $productions->firstItem() }} sampai {{ $productions->lastItem() }}
                                dari {{ $productions->total() }} entri
                            </div>
                            <div class="col-md-6">
                                @if ($productions->hasPages())
                                    <div class="d-flex justify-content-md-end">
                                        {{ $productions->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
