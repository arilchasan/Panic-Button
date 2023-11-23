@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <section class="w-auto p-6 shadow mx-5 my-2 rounded-md shadow-md ">
        <h2 class="text-lg font-weight-bold text-capitalize">Detail <span class="text-primary">{{ $user->name }}</span></h2>

        {{-- <form action="/dashboard/user/add-user" method="POST" enctype="multipart/form-data">
            @csrf --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <label class="form-label" for="name">Nama User</label>
                <input id="name" type="text" name="name" value="{{ $user->name }}" class="form-control"
                    readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="phone">Phone</label>
                <input id="phone" type="tel" name="phone" value="{{ $user->phone }}" class="form-control"
                    readonly>
            </div>
        </div>

        <di class="row mt-4">
            <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ $user->email }}" class="form-control"
                    readonly>
            </div>
            <div class="col-md-6 ">
                <div class="mb-3">
                    <label class="form-label" for="file_input">Foto Profile</label>
                </div>
                @if ($user->avatar == null)
                    <img src="{{ asset('/assets/user.jpg') }}" alt="User Avatar"
                        style="width: 100px; height: 100px; margin-top: 10px; border-radius: 50%;">
                @else
                <img src="{{ asset('/assets/profile/' . $user->avatar) }}" alt="User Avatar"
                    style="width: 100px; height: 100px; margin-top: 10px; border-radius: 50%;">
                @endif
            </div>

            <div class="col-md-12 text-end">
                <a href="/dashboard/user/{{ $user->name }}/history" class="btn btn-primary mr-5">History Pembayaran</a>
                <a href="/dashboard/user/all" class="btn btn-secondary ml-5">Kembali</a>
            </div>

            </div>

            {{-- </form> --}}
    </section>
@endsection
