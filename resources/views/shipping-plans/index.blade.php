@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Rencana Kirim</h3>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('shipping-plans.create') }}" class="btn btn-primary">Tambah Rencana Kirim</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor PO</th>
                                <th>Tanggal Kirim</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shippingPlans as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $plan->po_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</td>
                                <td>
                                    @if($plan->status == 'waiting_invoice')
                                        <span class="badge bg-warning">Menunggu Invoice</span>
                                    @elseif($plan->status == 'waiting_packing_list')
                                        <span class="badge bg-info">Menunggu Packing List</span>
                                    @elseif($plan->status == 'ready_for_booking')
                                        <span class="badge bg-primary">Siap Booking</span>
                                    @elseif($plan->status == 'booked')
                                        <span class="badge bg-success">Booked</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $plan->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $plan->creator->name ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
