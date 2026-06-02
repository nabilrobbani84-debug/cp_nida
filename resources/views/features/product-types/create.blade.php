@extends('layouts.app')

@section('title', 'Tambah Jenis Produk')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row align-items-center flex-md-row flex-column-reverse">
                <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <a href="{{ route('product-types.index') }}"
                        class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-chevron-left" style="line-height: 0;"></i>
                    </a>
                    <h3 class="mb-0">Tambah Jenis Produk</h3>
                </div>
                <div class="col-12 col-md-6 mt-md-0 mb-md-0 mb-4 mt-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-lg-end float-md-end float-start">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product-types.index') }}">Jenis Produk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section mt-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('product-types.store') }}" method="post">
                        @csrf
                        @include('features.product-types.partials._form', ['productType' => null])

                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <a href="{{ route('product-types.index') }}" class="btn btn-light-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
