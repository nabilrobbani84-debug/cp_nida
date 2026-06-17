@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Input Packing List Gudang</h3>
            </div>
        </div>
    </div>

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('packing-lists.store') }}" method="POST">
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
                                            <label>Nomor Packing List</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="packing_list_number" class="form-control @error('packing_list_number') is-invalid @enderror" name="packing_list_number" placeholder="PL-XXXXX" value="{{ old('packing_list_number') }}" required>
                                            @error('packing_list_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Packing List</button>
                                            <a href="{{ route('packing-lists.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
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
