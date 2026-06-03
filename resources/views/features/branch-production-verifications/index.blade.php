@extends('layouts.app')

@section('title', 'Verifikasi Produksi')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Verifikasi Produksi</h3>
                    <p class="text-muted mb-0 small">Data produksi harian berstatus <strong>Pending</strong> dari semua cabang</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end mb-md-0 float-start mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Verifikasi Produksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header pb-0">
                    <form action="{{ route('branch-production-verifications.index') }}" method="get"
                        class="row g-3 align-items-end">
                        <div class="col-12 col-md-4 col-lg-3">
                            <select name="id_branch" id="id_branch" class="form-select form-select-sm">
                                <option value="">Semua Cabang</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id_branch }}"
                                        {{ (string) $filters['id_branch'] === (string) $branch->id_branch ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <input type="date" name="production_date" id="production_date"
                                value="{{ $filters['production_date'] }}"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-md-4 col-lg-auto d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0 text-nowrap">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                            @if ($filters['id_branch'] || $filters['production_date'])
                                <a href="{{ route('branch-production-verifications.index') }}"
                                    class="btn btn-light-secondary btn-sm text-nowrap">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Tanggal</th>
                                    <th class="text-nowrap">Cabang</th>
                                    <th class="text-nowrap">Produk</th>
                                    <th class="text-nowrap">Jumlah Lolos QC</th>
                                    <th class="text-nowrap">Jumlah Cacat</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-center" style="width: 10rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productions as $production)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{ $production->production_date?->format('d/m/Y') }}
                                        </td>
                                        <td class="text-nowrap">{{ $production->branch?->branch_name }}</td>
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
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <form action="{{ route('branch-production-verifications.validate', $production) }}"
                                                    method="post" class="d-inline form-validate-production">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="btn btn-sm btn-success" title="Validasi">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger btn-reject-production"
                                                    title="Tolak"
                                                    data-action="{{ route('branch-production-verifications.reject', $production) }}"
                                                    data-product="{{ $production->product?->name }}"
                                                    data-branch="{{ $production->branch?->branch_name }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-muted py-5 text-center">
                                            Tidak ada data produksi pending.
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

    @include('features.branch-production-verifications.partials.reject-modal')
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.form-validate-production').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                App.confirm({
                    title: 'Validasi Data?',
                    text: 'Data akan disetujui dan siap untuk divisi Ekspor.',
                    confirmButtonText: 'Ya, Validasi',
                    cancelButtonText: 'Batal',
                    icon: 'question'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        const rejectModal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');
        const rejectNotes = document.getElementById('rejectNotes');

        document.querySelectorAll('.btn-reject-production').forEach(function(btn) {
            btn.addEventListener('click', function() {
                rejectForm.action = btn.getAttribute('data-action');
                document.getElementById('rejectProductName').textContent = btn.getAttribute('data-product') || '—';
                document.getElementById('rejectBranchName').textContent = btn.getAttribute('data-branch') || '—';
                rejectNotes.value = '';
                bootstrap.Modal.getOrCreateInstance(rejectModal).show();
            });
        });
    </script>
@endpush
