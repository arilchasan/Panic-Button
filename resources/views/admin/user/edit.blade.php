@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

    <section class="p-5 mt-4 mb-2 mx-4 rounded shadow">
        <h2 class="h5 font-weight-bold text-capitalize">Edit Data <span class="text-primary">{{ $user->name }}</span></h2>

        <form action="/dashboard/user/edit-user/{{ $user->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="name">Nama User</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label" for="phone">Phone</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="form-control">
            </div>

            <div class="mb-3 d-flex justify-content-center align-items-center">
                @if ($user->avatar)
                    <img id="avatarPreview" src="{{ asset('/assets/profile/' . $user->avatar) }}" alt="User Avatar"
                        style="max-width: 100px; margin-top: 5px;border-radius: 50%;">
                @elseif($user->avatar == null)
                    <img id="avatarPreview" src="{{ asset('/assets/user.jpg') }}" alt="User Avatar"
                        style="max-width: 100px; margin-top: 5px;border-radius: 50%;">
                @endif
                <div class="m-5 w-full">
                    <label class="form-label" for="file_input">Upload Avatar</label>
                    <input type="file" class="form-control" id="file_input" name="avatar" accept="image/svg+xml, image/png, image/jpeg"
                        onchange="previewFile()">
                    <p class="form-text" id="file_input_help">*SVG, PNG, JPG, JPEG</p>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <a href="/dashboard/user/all" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary ml-2">Simpan</button>
            </div>
        </form>
    </section>
@endsection

<script>
    function previewFile() {
        const preview = document.getElementById('avatarPreview');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ asset('/assets/user.jpg') }}";
        }
    }
</script>
