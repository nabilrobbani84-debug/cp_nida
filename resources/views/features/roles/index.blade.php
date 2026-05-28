@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Roles</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end mb-md-0 float-start mb-2">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Roles</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header pb-0">
                    <form action="{{ route('roles.index') }}" method="get" class="d-inline-block">
                        <div class="input-group input-group-sm" style="width: 16rem; max-width: 100%;">
                            <input type="text" name="search" value="{{ $search }}"
                                class="form-control form-control-sm" placeholder="Cari nama role…" autocomplete="off"
                                aria-label="Cari Role">
                            @if ($search !== '')
                                <a href="{{ route('roles.index') }}" class="btn btn-primary" type="button"
                                    title="Hapus Pencarian">&times;</a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead>
                                <tr>
                                    <th>Nama Role</th>
                                    <th>Dibuat pada</th>
                                    <th>Diperbarui pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $role->role_name }}</td>
                                        <td class="text-nowrap">{{ $role->created_at?->format('d F Y, H:i') ?? '—' }}</td>
                                        <td class="text-nowrap">{{ $role->updated_at?->format('d F Y, H:i') ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-5 text-center">
                                            @if ($search !== '')
                                                Tidak ada hasil untuk "<strong>{{ $search }}</strong>"
                                            @else
                                                Belum ada data role.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($roles->total() > 0)
                        <div class="row align-items-center g-2 mt-3">
                            <div class="col-md-6 small text-muted">
                                Menampilkan {{ $roles->firstItem() }} sampai {{ $roles->lastItem() }}
                                dari {{ $roles->total() }} entri
                                @if ($search !== '')
                                    · "<strong>{{ $search }}</strong>"
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($roles->hasPages())
                                    <div class="d-flex justify-content-md-end">
                                        {{ $roles->links() }}
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
