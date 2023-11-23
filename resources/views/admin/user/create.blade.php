@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <div class="p-5 rounded shadow mx-auto mt-2">
        <h2 class="text-lg font-weight-bold text-capitalize">Tambah Data User</h2>

        <form action="/dashboard/user/add-user" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-2">
                <div class="col-12">
                    <label class="form-label" for="name">Nama User</label>
                    <input id="name" type="text" name="name" placeholder="Masukkan Nama" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="example@gmail.com" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label" for="phone">Phone</label>
                    <input id="phone" type="tel" name="phone" placeholder="0891234567" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label" for="file_input">Upload Avatar</label>
                    <input class="form-control" aria-describedby="file_input_help" id="file_input" type="file" name="avatar"
                        accept="image/svg+xml, image/png, image/jpeg">
                    <p class="form-text" id="file_input_help">*SVG, PNG, JPG, JPEG</p>
                </div>
            </div>

            <div class="text-end">
                <a href="/dashboard/user/all" class="btn btn-secondary ml-2">Kembali</a>
                <button type="submit" class="btn btn-primary ml-2">Simpan</button>
            </div>
        </form>
    </div>
@endsection
