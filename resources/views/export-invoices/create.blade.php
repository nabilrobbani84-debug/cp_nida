@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Invoice Ekspor</h3>
            </div>
        </div>
    </div>

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('export-invoices.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shipping_plan_id" value="{{ $plan->id }}">
                                
                                <div class="form-body">
                                    <div class="row mb-4">
                                        <div class="col-md-4"><strong>Nomor PO:</strong></div>
                                        <div class="col-md-8">{{ $plan->po_number }}</div>
                                        <div class="col-md-4"><strong>Tanggal Kirim:</strong></div>
                                        <div class="col-md-8">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <label>Nomor Invoice</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" name="invoice_number" placeholder="INV-XXXXX" value="{{ old('invoice_number') }}" required>
                                            @error('invoice_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Tanggal Invoice</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="date" id="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                            @error('invoice_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Invoice</button>
                                            <a href="{{ route('export-invoices.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
