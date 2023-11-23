@extends('layouts.backend')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="container">
        <h2 class="ml-3 text-xl font-bold text-gray-900">Detail Informasi</h2>
        <div class="row justify-content-center shadow-md rounded-lg mx-2">
            <div class="col-md-8  overflow-hidden mx-5 my-2">
                @if ($info->image == null)
                    <img src="{{ asset('assets/img_information/404img.jpg') }}" alt=""
                        class="w-35 mx-auto d-flex justify-content-center align-items-center pt-3">
                @else
                    <img src="{{ asset('assets/img_information/' . $info->image) }}" alt=""
                        class="w-35 mx-auto d-flex justify-content-center align-items-center pt-3">
                @endif
                <div class="p-4 text-center">
                    <h2 class="text-2xl text-center font-bold mb-2">{{ $info->tittle }}</h2>

                    {!! htmlspecialchars_decode($info->description) !!}
                </div>
            </div>
        </div>
        <a href="/dashboard/information/all" class="btn btn-secondary w-20 ml-3 mt-2 text-sm">Kembali</a>
        <div class="pb-5"></div>
    </div>
@endsection
