@extends('layouts.backend')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" /> --}}

<section class="p-5 mx-4 shadow rounded mt-3">
    <h2 class="text-lg font-semibold capitalize">Edit Permissions</h2>

    <form action="/dashboard/permission/edit-permissions/{{ $permission->id }}" method="POST">
        @csrf
        <div class="row g-3 mt-4">
            <div class="col-md-12">
                <label class="form-label" for="name">Nama Permissions</label>
                <input id="name" type="text" name="name" value="{{ old('name', $permission->name) }}"
                    class="form-control" required>
            </div>

            {{-- <div class="col-md-6">
                <label class="form-label" for="guard_name">Nama Guard</label>
                <select id="guard_name" name="guard_name" value="{{ old('guard_name', $permission->guard_name) }}"
                    class="form-select">
                    <option value="admin">Admin</option>
                </select>
            </div> --}}
            <input type="hidden" value="admin" name="guard_name">
        </div>

        <div class="text-end mt-4">
            <a href="/dashboard/permission/all" class="btn btn-secondary ml-2">Kembali</a>
            <button type="submit"
                class="btn btn-primary ml-2">Simpan</button>
        </div>
    </form>
</section>
@endsection
