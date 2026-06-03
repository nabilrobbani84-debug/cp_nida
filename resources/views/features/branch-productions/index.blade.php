@extends('layouts.app')

@section('title', 'Riwayat Produksi')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Riwayat Produksi</h3>
                    <span class="badge bg-light-secondary text-dark">
                        Cabang: {{ auth()->user()->branch?->branch_name ?? '—' }}
                    </span>
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
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-stretch align-items-lg-end g-3">
                        <!-- Bagian Filter Form -->
                        <div class="flex-grow-1 mb-3 mb-lg-0">
                            <form action="{{ route('branch-productions.index') }}" method="get" class="row g-2 align-items-end">
                                <div class="col-12 col-md-5 col-lg-4">
                                    <label for="search" class="form-label small text-muted d-md-none">Cari</label>
                                    <input type="text" name="search" id="search" value="{{ $search }}"
                                        class="form-control form-control-sm" placeholder="Cari produk atau catatan…"
                                        autocomplete="off">
                                </div>
                                <div class="col-12 col-md-4 col-lg-3">
                                    <label for="status" class="form-label small text-muted d-md-none">Status</label>
                                    <select name="status" id="status" class="form-select form-select-sm">
                                        <option value="">Semua Status</option>
                                        @foreach ($statusOptions as $statusOption)
                                            <option value="{{ $statusOption->value }}"
                                                {{ $status === $statusOption->value ? 'selected' : '' }}>
                                                {{ $statusOption->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3 col-lg-auto d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0">
                                        <i class="bi bi-funnel me-1"></i> Terapkan
                                    </button>
                                    @if ($search !== '' || $status !== '')
                                        <a href="{{ route('branch-productions.index') }}"
                                            class="btn btn-light-secondary btn-sm" title="Reset filter">Reset</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        
                        <!-- Bagian Tombol Input Produksi -->
                        @unless ($readOnly)
                            <div class="ms-lg-3 text-end">
                                <a href="{{ route('branch-productions.create') }}" class="btn btn-primary btn-sm w-100 text-nowrap">
                                    <i class="bi bi-plus-lg me-1"></i> Input Produksi
                                </a>
                            </div>
                        @endunless
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Tanggal</th>
                                    <th class="text-nowrap">Produk</th>
                                    <th class="text-nowrap">Jumlah Lolos QC</th>
                                    <th class="text-nowrap">Jumlah Cacat</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Catatan</th>
                                    <th class="text-center" style="width: 6rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productions as $production)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{ $production->production_date?->format('d/m/Y') }}
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="d-block fw-semibold">{{ $production->product?->name }}</span>
                                            <span class="small text-muted">{{ $production->product?->code }}</span>
                                        </td>
                                        <td class="text-nowrap">{{ number_format($production->good_products) }}</td>
                                        <td class="text-nowrap">{{ number_format($production->rejected_products) }}</td>
                                        <td>
                                            @include('features.branch-productions.partials.status-badge', [
                                                'status' => $production->status,
                                            ])
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($production->status === \App\Enums\BranchProductionStatus::Rejected && filled($production->notes))
                                                <span class="text-muted" title="{{ $production->notes }}">
                                                    {{ Str::limit($production->notes, 40) }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
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
                                        <td colspan="7" class="text-muted py-5 text-center">
                                            @if ($search !== '' || $status !== '')
                                                Tidak ada data yang cocok dengan filter.
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
