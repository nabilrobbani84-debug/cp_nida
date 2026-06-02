@extends('layouts.app')

@section('title', 'Cabang')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Cabang</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end mb-md-0 float-start mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cabang</li>
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
                        <form action="{{ route('branches.index') }}" method="get" class="d-flex align-items-center"
                            style="max-width: 100%;">
                            <div class="input-group input-group-sm w-100" style="min-width: 16rem;">
                                <input type="text" name="search" value="{{ $search }}"
                                    class="form-control form-control-sm" placeholder="Cari nama atau lokasi…"
                                    autocomplete="off" aria-label="Cari Cabang">
                                @if ($search !== '')
                                    <a href="{{ route('branches.index') }}" class="btn btn-primary" type="button"
                                        title="Hapus Pencarian">&times;</a>
                                @endif
                            </div>
                        </form>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('branches.create') }}"
                                class="btn btn-primary btn-sm w-100 w-lg-auto ms-lg-auto">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Cabang
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th>Nama Cabang</th>
                                    <th>Lokasi</th>
                                    <th>Dibuat pada</th>
                                    <th class="text-center" style="width: 12rem;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($branches as $branch)
                                    <tr>
                                        <td>{{ $branch->branch_name }}</td>
                                        <td>{{ $branch->location }}</td>
                                        <td class="text-nowrap">{{ $branch->created_at?->format('d F Y, H:i') }}</td>
                                        <td class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('branches.show', $branch) }}"
                                                class="btn btn-sm btn-light-warning" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('branches.edit', $branch) }}"
                                                class="btn btn-sm btn-light-primary" title="Ubah">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('branches.destroy', $branch) }}" method="post"
                                                class="d-inline form-delete-branch"
                                                data-branch-name="{{ $branch->branch_name }}">
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
                                        <td colspan="4" class="text-muted py-5 text-center">
                                            @if ($search !== '')
                                                Tidak ada hasil untuk "<strong>{{ $search }}</strong>"
                                            @else
                                                Belum ada data cabang.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($branches->total() > 0)
                        <div class="row align-items-center g-2 mt-3">
                            <div class="col-md-6 small text-muted">
                                Menampilkan {{ $branches->firstItem() }} sampai {{ $branches->lastItem() }}
                                dari {{ $branches->total() }} entri
                                @if ($search !== '')
                                    · "<strong>{{ $search }}</strong>"
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($branches->hasPages())
                                    <div class="d-flex justify-content-md-end">
                                        {{ $branches->links() }}
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
        document.querySelectorAll('.form-delete-branch').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var name = form.getAttribute('data-branch-name') || 'cabang ini';
                App.confirm({
                    title: 'Hapus Cabang?',
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
