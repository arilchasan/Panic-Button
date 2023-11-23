@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="w-auto p-5 mx-5 my-2 rounded shadow">
        <h2 class="text-lg font-semibold  capitalize">Tambah Data Kontak</h2>

        <form action="/dashboard/contact/add-contact" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-4">
                <div class="col-md-12">
                    <label class="form-label" for="name">Nama</label>
                    <input id="name" type="text" name="name" placeholder="Masukkan Nama"
                        class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="type">Type</label>
                    <input id="type" type="text" name="type" placeholder="Masukkan Type"
                        class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="value">Value</label>
                    <input id="value" type="text" name="value" placeholder="Masukkan Value"
                        class="form-control" required>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <a href="/dashboard/contact/all" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
