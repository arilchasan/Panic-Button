@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="container p-5 mx-auto my-2 rounded shadow">
        <h2 class="text-lg font-semibold  capitalize">Edit Data Informasi</h2>

        <form action="/dashboard/information/edit-information/{{ $info->tittle }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-4">
                <div class="col-md-12">
                    <label class="form-label" for="tittle">Judul Informasi</label>
                    <input id="tittle" type="text" name="tittle" value="{{ old('tittle', $info->tittle) }}"
                        class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="editor" name="description" class="form-control" rows="5">
                        {{ htmlspecialchars_decode(old('description', $info->description)) }}
                    </textarea>
                </div>

                <div class="col-md-12">
                    @if ($info->image == null)
                        <img id="avatarPreview" src="{{ asset('assets/img_information/404img.jpg') }}" alt=""
                            class="mx-auto d-block" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                    @else
                        <img id="avatarPreview" src="{{ asset('assets/img_information/' . $info->image) }}" alt=""
                            class="mx-auto d-block" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                    @endif
                    <label class="form-label" for="file_input">Upload Foto</label>
                    <input type="file" class="form-control" id="file_input" name="image"
                        accept="image/svg+xml, image/png, image/jpeg" onchange="previewFile()">
                    <p class="form-text text-black-500" id="file_input_help">*SVG, PNG, JPG, JPEG</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <a href="/dashboard/information/all" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit"
                            class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    <script>
        function previewFile() {
            const preview = document.getElementById('avatarPreview');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
@endsection
