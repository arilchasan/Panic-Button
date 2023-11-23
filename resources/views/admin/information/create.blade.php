@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="container p-5 mx-auto my-2 rounded shadow">
        <h2 class="text-lg font-semibold  capitalize">Tambah Data Informasi</h2>

        <form action="/dashboard/information/add-information" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-4">
                <div class="col-md-12">
                    <label class="form-label" for="tittle">Judul Informasi</label>
                    <input id="tittle" type="text" name="tittle" placeholder="Masukkan Judul"
                        class="form-control" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="editor" type="text" name="description"
                        class="form-control" placeholder="Masukkan Deskripsi" required></textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="file_input">Upload Foto</label>
                    <input
                        class="form-control"
                        aria-describedby="file_input_help" id="file_input" type="file" name="image"
                        accept="image/svg+xml, image/png, image/jpeg">
                    <p class="form-text text-black-500" id="file_input_help">*SVG, PNG, JPG, JPEG</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <a href="/dashboard/information/all" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
