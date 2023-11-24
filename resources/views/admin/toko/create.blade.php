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
        <h2 class="mb-4 text-xl font-bold">Tambah Panic Button</h2>
        <form action="/dashboard/store/add-store" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="brand" class="form-label">Nama Panic Button</label>
                    <input type="text" name="name" value="" id="brand" class="form-control"
                        placeholder="Masukkan Nama Toko" required autocomplete="off">
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Nama Pemilik Panic Button</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="0">Pilih Pemilik Toko</option>
                        @foreach ($user as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Alamat</label>
                    <textarea type="text" name="address" class="form-control" placeholder="Masukkan Alamat" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Subscription</label>
                    <select name="subsription_id" class="form-select">
                        <option selected>Pilih Subscription</option>
                        @foreach ($subs as $index)
                            <option value="{{ $index->id }}">{{ $index->subscription_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="brand" class="form-label">Status Panic Button</label>
                    <select name="status" class="form-select">
                        <option selected>Pilih Status</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>

                    </select>
                </div>
                {{-- <div class="col-md-6">
                    <label for="brand" class="form-label">Key</label>
                    <input type="text" name="key" value="" id="key" class="form-control"
                    placeholder="Masukkan Key" required>
                </div> --}}
                <div class="col-md-6">
                    <label for="brand" class="form-label">Status Aktif Panic Button</label>
                    <select name="status_active" class="form-select">
                        <option selected>Pilih Statuf Aktif Panic Button</option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Provinsi</label>
                    <select id="province" class="form-select" name="province_id">
                        <option selected>Pilih Provinsi</option>
                        @foreach ($province as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kabupaten</label>
                    <select id="regencies" class="form-select" name="regencies_id">
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kecamatan</label>
                    <select id="district" class="form-select" name="district_id">
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Desa</label>
                    <select id="village" class="form-select" name="village_id">
                    </select>
                </div>
                <div class="col-md-12">
                    <div id="map" class="w-100"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="latitude" value="" required
                        placeholder="Masukkan Latitude">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="longitude" value="" required
                        placeholder="Masukkan Longitude">
                </div>
            </div>
            <a href="/dashboard/store/all" class="btn btn-success mt-4">Kembali</a>
            <button type="submit" class="btn btn-primary mt-4">Simpan</button>
        </form>
    </section>
    <script type="module">
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        const leafletMap = L.map('map', {
            fullscreenControl: true,

            fullscreenControl: {
                pseudoFullscreen: false,

            },
            minZoom: 2,
            scrollWheelZoom: true,
            setZoomControl: true,
            dragging: true,
        }).setView([-7.6145, 110.7126], 8);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {}).addTo(leafletMap);

        let theMarker = {};

        leafletMap.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 10);
            let longitude = e.latlng.lng.toString().substring(0, 11);
            let popup = L.popup()
                .setLatLng([latitude, longitude])
                .setContent("Latitude : " + latitude + " - Longitude : " + longitude)
                .openOn(leafletMap);

            if (theMarker != undefined) {
                leafletMap.removeLayer(theMarker);
            };
            latitudeInput.value = latitude;
            longitudeInput.value = longitude;
            theMarker = L.marker([latitude, longitude]).addTo(leafletMap);

        });

        var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
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
                    maxZoom: 20
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

            console.log(idprovince);
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

            console.log(idregencies);
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

            console.log(iddistrict);
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
        $('#village').on('change', function() {
            const idvillage = $('#village').val();

            console.log(idvillage);
        })

    })
</script>
