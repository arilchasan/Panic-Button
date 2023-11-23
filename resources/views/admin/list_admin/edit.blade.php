@extends('layouts.backend')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

<section class="p-5 mx-3 mt-3 shadow rounded">
    <h2 class="text-lg font-semibold capitalize">Edit {{ $admin->name }}</h2>

    <form action="/dashboard/admin/edit-admin/{{ $admin->id }}" method="POST">
        @csrf
        <div class="row g-3 mt-4">
            <div class="col-md-12">
                <label class="form-label" for="name">Username</label>
                <input id="name" type="text" name="name" value="{{ old('name', $admin->name) }}" required
                    class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input id="password" type="password" name="password" value="{{ old('password') }}" required
                        placeholder="Masukkan password baru" class="form-control">

                        <span class="input-group-text" id="password-addon" onclick="togglePasswordVisibility()">
                            <i id="password-icon" class="far fa-eye"></i>
                        </span>

                </div>
            </div>
            <div class="col-md-12">
                <label class="form-label" for="role_id">Role</label>
                <select id="role_id" name="role_id" required class="form-select">
                    @foreach ($role as $item)
                        @if (old('role_id', $admin->role_id) == $item->id)
                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                        @else
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-end mt-6">
            <a href="/dashboard/admin/all" class="btn btn-secondary ml-2">Kembali</a>
            <button type="submit" class="btn btn-primary ml-2">Simpan</button>
        </div>
    </form>
</section>
@endsection

<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById("password");
        const passwordIcon = document.getElementById("password-icon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            passwordIcon.className = "far fa-eye-slash"; // Change to the eye-slash icon
        } else {
            passwordField.type = "password";
            passwordIcon.className = "far fa-eye"; // Change back to the eye icon
        }
    }

    function closeAlert(alertId) {
        var alert = document.getElementById(alertId);
        if (alert) {
            alert.style.display = 'none';
        }
    }
</script>
