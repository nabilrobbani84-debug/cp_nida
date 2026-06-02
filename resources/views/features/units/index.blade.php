@extends('layouts.app')

@section('title', 'Unit')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Unit</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end mb-md-0 float-start mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Unit</li>
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
                        <form action="{{ route('units.index') }}" method="get" class="d-flex align-items-center"
                            style="max-width: 100%;">
                            <div class="input-group input-group-sm w-100" style="min-width: 16rem;">
                                <input type="text" name="search" value="{{ $search }}"
                                    class="form-control form-control-sm" placeholder="Cari nama unit…"
                                    autocomplete="off" aria-label="Cari Unit">
                                @if ($search !== '')
                                    <a href="{{ route('units.index') }}" class="btn btn-primary" type="button"
                                        title="Hapus Pencarian">&times;</a>
                                @endif
                            </div>
                        </form>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('units.create') }}"
                                class="btn btn-primary btn-sm w-100 w-lg-auto ms-lg-auto">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Unit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Dibuat pada</th>
                                    <th class="text-center" style="width: 12rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($units as $unit)
                                    <tr>
                                        <td>{{ $unit->name }}</td>
                                        <td class="text-nowrap">{{ $unit->created_at?->format('d F Y, H:i') }}</td>
                                        <td class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('units.show', $unit) }}"
                                                class="btn btn-sm btn-light-warning" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('units.edit', $unit) }}"
                                                class="btn btn-sm btn-light-primary" title="Ubah">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('units.destroy', $unit) }}" method="post"
                                                class="d-inline form-delete-unit" data-unit-name="{{ $unit->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted py-5 text-center">
                                            @if ($search !== '')
                                                Tidak ada hasil untuk "<strong>{{ $search }}</strong>"
                                            @else
                                                Belum ada data unit.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($units->total() > 0)
                        <div class="row align-items-center g-2 mt-3">
                            <div class="col-md-6 small text-muted">
                                Menampilkan {{ $units->firstItem() }} sampai {{ $units->lastItem() }}
                                dari {{ $units->total() }} entri
                                @if ($search !== '')
                                    · "<strong>{{ $search }}</strong>"
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($units->hasPages())
                                    <div class="d-flex justify-content-md-end">
                                        {{ $units->links() }}
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

@push('scripts')
    <script>
        document.querySelectorAll('.form-delete-unit').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var name = form.getAttribute('data-unit-name') || 'unit ini';
                App.confirm({
                    title: 'Hapus Unit?',
                    text: 'Yakin ingin menghapus "' + name + '"?',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
