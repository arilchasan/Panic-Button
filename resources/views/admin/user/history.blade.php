@extends('layouts.backend')

@section('content')

    <div class="w-auto p-4">
        <h1 class="h3 mb-4">History Pembayaran</h1>
        <div class="card">
            <ul class="list-group list-group-flush">
                @if ($payment->isEmpty())
                    <li class="list-group-item">Belum ada history pembayaran</li>
                @endif
                @foreach ($payment as $s)
                    <a href="/dashboard/user/{{ $user->name }}/history/detail/{{ $s->id }}" class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 text-primary">{{ $s->code_bill }}</p>
                            <p class="mb-0 text-secondary">{{ \Carbon\Carbon::parse($s->payment_time)->isoFormat('MMM D, YYYY') }}</p>
                        </div>
                        <div class="mt-2 d-flex justify-content-between">
                            <p class="mb-0 text-secondary">
                                {{ \Carbon\Carbon::parse($s->transaction_time)->isoFormat('MMM D, YYYY hh:mm A') }}
                            </p>
                            <p class="mb-0 text-secondary">
                                Rp{{ number_format($s->package_fee + $s->installation_fee + $s->admin_fee, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
    <a href="/dashboard/user/detail/{{ $user->name }}" class="btn btn-secondary mt-3" style="width: 10%;margin-left: 25px;">Kembali</a>
    <script>
        function closeAlert(alertId) {
            var alert = document.getElementById(alertId);
            if (alert) {
                alert.style.display = 'none';
            }
        }
    </script>
@endsection
