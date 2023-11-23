@extends('layouts.backend')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
<style>
    #map {
        height: 400px;
    }
</style>
    <div class="container py-5 px-5">
        <h2 class="mb-4 text-center font-weight-bold">Detail {{ $toko->name }}</h2>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nama Toko</label>
                        <input type="text" name="name" value="{{ $toko->name }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea type="text" name="address" class="form-control" readonly>{{ $toko->address }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="subscription_name">Subscription</label>
                        <input type="text" name="subscription_name" value="{{ $toko->subscription->subscription_name }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="province_name">Provinsi</label>
                        <input type="text" name="province_name" class="form-control" value="{{ $toko->province->name }}" readonly>
                    </div>
                </div>
            </div>
            <div id="map" class="mb-3"></div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="number" name="latitude" class="form-control" value="{{ $toko->latitude }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="number" name="longitude" class="form-control" value="{{ $toko->longitude }}" readonly>
                    </div>
                </div>
            </div>
            <a href="/dashboard/user/daftar-toko/{{ $user->name }}" class="btn btn-secondary">Kembali</a>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>

    <script>
        const map = L.map('map').setView([{{ $toko->latitude }}, {{ $toko->longitude }}], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);
        L.marker([{{ $toko->latitude }}, {{ $toko->longitude }}]).addTo(map);
    </script>

@endsection
