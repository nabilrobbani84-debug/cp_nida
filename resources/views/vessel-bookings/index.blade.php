@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Booking Kapal (Ekspor)</h3>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Tanggal Kirim</th>
                            <th>Status Rencana</th>
                            <th>No Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shippingPlans as $plan)
                        <tr>
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
                                @endif
                            </td>
                            <td>
                                @if($plan->booking)
                                    {{ $plan->booking->booking_number }}<br>
                                    <small>{{ \Carbon\Carbon::parse($plan->booking->booking_date)->format('d M Y') }}</small>
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->status == 'ready_for_booking')
                                    <a href="{{ route('vessel-bookings.create', ['shipping_plan_id' => $plan->id]) }}" class="btn btn-sm btn-primary">Input Booking</a>
                                @elseif($plan->status == 'booked')
                                    <button class="btn btn-sm btn-success" disabled>Selesai</button>
                                @else
                                    <span class="badge bg-secondary">Syarat Belum Lengkap</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
