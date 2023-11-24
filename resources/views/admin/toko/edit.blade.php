@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <section class="p-5 mx-2 mt-3 shadow rounded">
        <h2 class="mb-4 text-xl font-bold">Edit {{ old('name', $toko->name) }}</h2>
        <form action="/dashboard/store/edit-store/{{ $toko->name }}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Panic Button</label>
                    <input type="text" name="name" id="brand" value="{{ old('name', $toko->name) }}"
                        class="form-control" placeholder="Masukkan Nama Toko" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pemilik Panic Button</label>
                    <select name="user_id" class="form-select">
                        @foreach ($user as $index)
                            @if (old('user_id', $toko->user_id) == $index->id)
                                <option value="{{ $index->id }}" selected>{{ $index->name }}</option>
                            @else
                                <option value="{{ $index->id }}">{{ $index->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat</label>
                    <textarea type="text" name="address" class="form-control" placeholder="Masukkan Alamat" required>{{ old('address', $toko->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subscription</label>
                    <select name="subsription_id" class="form-select">
                        @foreach ($subs as $index)
                            @if (old('subsription_id', $toko->subsription_id) == $index->id)
                                <option value="{{ $index->id }}" selected>{{ $index->subscription_name }}</option>
                            @else
                                <option value="{{ $index->id }}">{{ $index->subscription_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Status Panic Button</label>
                    <select name="status" class="form-select">

                        <option value="online" @if (old('status', $toko->status) == 'online') selected @endif>Online</option>
                        <option value="offline" @if (old('status', $toko->status) == 'offline') selected @endif>Offline</option>

                    </select>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Key</label>
                    <input type="text" name="key" value="{{ old('key', $toko->key) }}" id="key"
                        class="form-control" placeholder="Masukkan Key" readonly>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Status Aktif Panic Button</label>
                    <select name="status_active" class="form-select">
                        <option value="true" @if (old('status_active', $toko->status_active) == 'true') selected @endif>True</option>
                        <option value="false" @if (old('status_active', $toko->status_active) == 'false') selected @endif>False</option>
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Provinsi</label>
                    <select id="province" class="form-select" name="province_id">
                        <option selected=>Pilih Provinsi</option>
                        @foreach ($province as $p)
                            @if (old('province_id', $toko->province_id) == $p->id)
                                <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                            @else
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kabupaten</label>
                    <select id="regencies" class="form-select" name="regencies_id">

                        @foreach ($regencies as $index)
                            @if (old('regencies_id', $toko->regencies_id) == $index->id)
                                <option value="{{ $index->id }}" selected>{{ $index->name }}</option>
                            @else
                                <option value="{{ $index->id }}">{{ $index->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kecamatan</label>
                    <select id="district" class="form-select" name="district_id">

                        @foreach ($districts as $index)
                            @if (old('district_id', $toko->district_id) == $index->id)
                                <option value="{{ $index->id }}" selected>{{ $index->name }}</option>
                            @else
                                <option value="{{ $index->id }}">{{ $index->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Desa</label>
                    <select id="village" class="form-select" name="village_id">

                        @foreach ($villages as $index)
                            @if (old('village_id', $toko->village_id) == $index->id)
                                <option value="{{ $index->id }}" selected>{{ $index->name }}</option>
                            @else
                                <option value="{{ $index->id }}">{{ $index->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <div id="map" class="w-100"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" id="latitude" class="form-control"
                        value="{{ old('latitude', $toko->latitude) }}" required placeholder="Masukkan Latitude">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" id="longitude" class="form-control"
                        value="{{ old('longitude', $toko->longitude) }}" required placeholder="Masukkan Longitude">
                </div>
            </div>
            <a href="/dashboard/store/all" class="btn btn-success mt-4">Kembali
            </a>
            <button type="submit" class="btn btn-primary mt-4">Simpan
            </button>
        </form>
    </section>


    <script type="module">
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const tokoLatitude = {{ $toko->latitude }};
        const tokoLongitude = {{ $toko->longitude }};
        const leafletMap = L.map('map', {
            fullscreenControl: true,

            fullscreenControl: {
                pseudoFullscreen: false,

            },
            minZoom: 2,
            scrollWheelZoom: true,
        }).setView([{{ $toko->latitude }}, {{ $toko->longitude }}], 8);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {}).addTo(leafletMap);

        let markers = [];

        const theMarker = L.marker([{{ $toko->latitude }}, {{ $toko->longitude }}], 8).addTo(leafletMap);
        markers.push(theMarker);

        leafletMap.on('click', function(e) {
            // hapus semua mark lama dari peta
            for (let i = 0; i < markers.length; i++) {
                leafletMap.removeLayer(markers[i]);
            }
            markers = [];

            let latitude = e.latlng.lat ? e.latlng.lat.toString().substring(0, 10) : tokoLatitude;
            let longitude = e.latlng.lng ? e.latlng.lng.toString().substring(0, 11) : tokoLongitude;
            let popup = L.popup()
                .setLatLng([latitude, longitude])
                .setContent("Latitude : " + latitude + " - Longitude : " + longitude)
                .openOn(leafletMap);
            let newMarker = L.marker([latitude, longitude], 8).addTo(leafletMap);
            markers.push(newMarker);

            latitudeInput.value = latitude;
            longitudeInput.value = longitude;
        });

        var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
            })
            .on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]).addTo(leafletMap);
                leafletMap.fitBounds(poly.getBounds(), {
                    padding: [50, 50],
                    maxZoom: 17
                });

                if (typeof poly !== 'undefined') {
                    leafletMap.removeLayer(poly);
                }
            })
            .addTo(leafletMap);

        latitudeInput.addEventListener('input', function() {
            if (theMarker) {
                leafletMap.removeLayer(theMarker);
            }
            let latitude = latitudeInput.value;
            let longitude = longitudeInput.value;
            if (latitude && longitude) {
                theMarker = L.marker([latitude, longitude]).addTo(leafletMap);
                leafletMap.setView([latitude, longitude], 8);
            }
        });

        longitudeInput.addEventListener('input', function() {
            if (theMarker) {
                leafletMap.removeLayer(theMarker);
            }
            let latitude = latitudeInput.value;
            let longitude = longitudeInput.value;
            if (latitude && longitude) {
                theMarker = L.marker([latitude, longitude]).addTo(leafletMap);
                leafletMap.setView([latitude, longitude], 8);
            }
        });
    </script>
@endsection



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        });
    })

    $(function() {
        $('#province').on('change', function() {
            const idprovince = $('#province').val();

            // console.log(idprovince);
            $.ajax({
                type: 'POST',
                url: "{{ route('getRegencies') }}",
                data: {
                    idprovince: idprovince
                },
                cache: false,

                success: function(msg) {
                    // console.log(data);
                    $('#regencies').html(msg);
                    $('#district').html('');
                    $('#village').html('');
                },
                error: function(data) {
                    console.log('error : ', data);
                }
            })
        })

        $('#regencies').on('change', function() {
            const idregencies = $('#regencies').val();

            // console.log(idprovince);
            $.ajax({
                type: 'POST',
                url: "{{ route('getDistrict') }}",
                data: {
                    idregencies: idregencies
                },
                cache: false,

                success: function(msg) {
                    $('#district').html(msg);
                },
                error: function(data) {
                    console.log('error : ', data);
                }
            })
        })

        $('#district').on('change', function() {
            const iddistrict = $('#district').val();

            // console.log(idprovince);
            $.ajax({
                type: 'POST',
                url: "{{ route('getVillage') }}",
                data: {
                    iddistrict: iddistrict
                },
                cache: false,

                success: function(msg) {
                    $('#village').html(msg);
                },
                error: function(data) {
                    console.log('error : ', data);
                }
            })
        })

    })
</script>
