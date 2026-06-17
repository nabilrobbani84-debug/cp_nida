@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Input Booking Kapal</h3>
            </div>
        </div>
    </div>

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ route('vessel-bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="shipping_plan_id" value="{{ $plan->id }}">
                                
                                <div class="form-body">
                                    <div class="row mb-4">
                                        <div class="col-md-3"><strong>Nomor PO:</strong></div>
                                        <div class="col-md-3">{{ $plan->po_number }}</div>
                                        <div class="col-md-3"><strong>Tanggal Kirim:</strong></div>
                                        <div class="col-md-3">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</div>
                                        
                                        <div class="col-md-3 mt-2"><strong>Nomor Invoice:</strong></div>
                                        <div class="col-md-3 mt-2">{{ $plan->invoice->invoice_number ?? '-' }}</div>
                                        <div class="col-md-3 mt-2"><strong>Packing List:</strong></div>
                                        <div class="col-md-3 mt-2">{{ $plan->packingList->packing_list_number ?? '-' }}</div>
                                    </div>
                                    <hr>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <label>Nomor Booking</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="booking_number" class="form-control @error('booking_number') is-invalid @enderror" name="booking_number" placeholder="BKG-XXXXX" value="{{ old('booking_number') }}" required>
                                            @error('booking_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Tanggal Booking</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required>
                                            @error('booking_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Simpan Booking</button>
                                            <a href="{{ route('vessel-bookings.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
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
