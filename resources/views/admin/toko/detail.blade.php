@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <section class="p-5 mx-2 mt-3 rounded shadow ">
        <h2 class="mb-4 text-xl font-bold">Detail {{ $toko->name }}</h2>
        <form action="#">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="brand" class="form-label">Nama Toko</label>
                    <input type="text" name="name" value="{{ $toko->name }}"
                        class="form-control" placeholder="Product brand" readonly>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Nama Pemilik Toko</label>
                    <input type="text" name="name" value="{{ $toko->user->name }}" id="brand"
                        class="form-control" readonly>
                </div>
                <div class="col-md-12">
                    <label for="brand" class="form-label">Alamat</label>
                    <textarea type="text" name="address"
                        class="form-control" readonly>{{ $toko->address }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="brand" class="form-label">Subscription</label>
                    <input type="text" name="name" value="{{ $toko->subscription->subscription_name }}" id="brand"
                        class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Status</label>
                    <input type="text" name="status"
                        class="form-control" value="{{ $toko->status }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Key</label>
                    <input type="text" name="key"
                        class="form-control" value="{{ $toko->key }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Status Aktif</label>
                    <input type="text" name="status_active"
                        class="form-control" value="{{ $toko->status_active }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Provinsi</label>
                    <input type="text" name="province_id"
                        class="form-control" value="{{ $toko->province->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="item-weight" class="form-label">Kabupaten</label>
                    <input type="text" name="regencies_id"
                        class="form-control" value="{{ $toko->regencies->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Kecamatan</label>
                    <input type="text" name="district_id"
                        class="form-control" value="{{ $toko->district->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="item-weight" class="form-label">Desa</label>
                    <input type="text" name="village_id"
                        class="form-control" value="{{ $toko->village->name }}" readonly>
                </div>
                <div class="col-md-12">
                    <div id="map" class="w-100"></div>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">Latitude</label>
                    <input type="number" name="latitude"
                        class="form-control" value="{{ $toko->latitude }}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="item-weight" class="form-label">Longitude</label>
                    <input type="number" name="item-weight"
                        class="form-control" value="{{ $toko->longitude }}" readonly>
                </div>
            </div>
            <a href="/dashboard/store/all"
                class="btn btn-primary mt-4">Kembali</a>
        </form>
    </section>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>

    <script>
        const map = L.map('map').setView([{{ $toko->latitude }}, {{ $toko->longitude }}], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);
        L.marker = L.marker([{{ $toko->latitude }}, {{ $toko->longitude }}]).addTo(map);
    </script>
@endsection
