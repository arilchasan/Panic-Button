@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mx-5 my-2 rounded shadow">
        <h2 class="text-lg font-semibold  capitalize">Edit Data Kontak</h2>

        <form action="/dashboard/contact/edit-contact/{{ $contact->name }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row g-3 mt-4">

                <div class="col-md-12">
                    <label class="form-label" for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $contact->name) }}"
                        class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="type">Type</label>
                    <input id="type" type="text" name="type" value="{{ old('type', $contact->type) }}"
                        class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label" for="value">Value</label>
                    <input id="value" type="text" name="value" value="{{ old('value', $contact->value) }}"
                        class="form-control">
                </div>
                
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <a href="/dashboard/contact/all" class="btn btn-secondary me-2">Kembali</a>
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
