@extends('layouts.backend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <div class="p-4" style="height: 10%">
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title fw-bold">Detail Pembayaran</h3>
                <p class="card-text">Informasi lengkap mengenai pembayaran.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Kode Tagihan</span>
                    <span>{{ $payment->code_bill }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Waktu Pembayaran</span>
                    <span>{{ \Carbon\Carbon::parse($payment->payment_time)->isoFormat('MMM D, YYYY hh:mm A') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Waktu Transaksaksi</span>
                    <span>{{ \Carbon\Carbon::parse($payment->transaction_time)->isoFormat('MMM D, YYYY hh:mm A') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Status</span>
                    @if ($payment->status === 'paid')
                        <span class="badge bg-success">{{ $payment->status }}</span>
                    @elseif ($payment->status === 'pending')
                        <span class="badge bg-warning text-dark">{{ $payment->status }}</span>
                    @elseif ($payment->status === 'canceled')
                        <span class="badge bg-danger">{{ $payment->status }}</span>
                    @endif
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Nama Subscriptions</span>
                    <span>{{ $payment->subscription->subscription_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Biaya Paket</span>
                    <span>Rp{{ number_format($payment->package_fee, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Biaya Instalasi</span>
                    <span>Rp{{ number_format($payment->installation_fee, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Biaya Admin</span>
                    <span>Rp{{ number_format($payment->admin_fee, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Total Keseluruhan</span>
                    <span>Rp{{ number_format($payment->admin_fee + $payment->installation_fee + $payment->package_fee, 0, ',', '.') }}</span>
                </li>
            </ul>
        </div>
    </div>
    <a href="/dashboard/user/{{ $user->name }}/history" class="btn btn-secondary ml-3 px-2 py-1"
        style="width: 10%;margin-left: 25px;">Kembali</a>
@endsection
