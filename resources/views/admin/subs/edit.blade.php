@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <div class="container mt-5">
        <div class="card rounded shadow">
            <div class="card-body p-6">
                <h2 class="card-title text-lg font-semibold capitalize">Edit Subscriptions {{ $subs->subscription_name }}</h2>
                <form action="/dashboard/subscriptions/edit-subscription/{{$subs->subscription_name}}" method="POST" onsubmit="removeFormattingBeforeSubmit(this);">
                    @csrf
                    <div class="mb-3">
                        <label for="subscription_name" class="form-label">Nama Subscriptions</label>
                        <input id="subscription_name" type="text" name="subscription_name"
                            class="form-control" value="{{ $subs->subscription_name }}">
                    </div>

                    <div class="mb-3">
                        <label for="price_installation" class="form-label">Harga Instalasi</label>
                        <input id="price_installation" type="text" name="price_installation"
                            class="form-control" value="{{ number_format($subs->price_installation, 0, '.', '.') }}" oninput="formatCurrency(this)">
                    </div>

                    <div class="mb-3">
                        <label for="maintenance_price" class="form-label">Harga Maintenance</label>
                        <input id="maintenance_price" type="text" name="maintenance_price"
                            class="form-control" value="{{ number_format($subs->maintenance_price, 0, '.', '.') }}" oninput="formatCurrency(this)">
                    </div>

                    <div class="mb-3">
                        <label for="day" class="form-label">Masa Berlaku</label>
                        <input id="day" type="text" name="day"
                            class="form-control" value="{{ $subs->day }}">
                    </div>

                    <div class="text-end mt-4">
                        <a href="/dashboard/subscriptions/index" class="btn btn-secondary ml-2">Kembali</a>
                        <button type="submit"
                            class="btn btn-primary ml-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function closeAlert(alertId) {
        var alert = document.getElementById(alertId);
        if (alert) {
            alert.style.display = 'none';
        }
    }
</script>

<script>
    function formatCurrency(input) {
        const numericValue = input.value.replace(/[^0-9]/g, '');
        const formattedValue = new Intl.NumberFormat('id-ID').format(numericValue);

        input.value = formattedValue;
    }

    function removeFormattingBeforeSubmit(form) {

        const priceInput = form.querySelector('input[name="price_installation"]');
        const maintenanceInput = form.querySelector('input[name="maintenance_price"]');

        const numericValue = priceInput.value.replace(/[^0-9]/g, '');
        const numericMaintenance = maintenanceInput.value.replace(/[^0-9]/g, '');

        priceInput.value = numericValue;
        maintenanceInput.value = numericMaintenance;
    }
</script>
