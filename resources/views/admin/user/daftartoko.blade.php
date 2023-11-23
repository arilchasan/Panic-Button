@extends('layouts.backend')

@section('content')

@section('css_before')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('js_after')
  <!-- jQuery (required for DataTables plugin) -->
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

  <!-- Page JS Code -->
  <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>
@endsection
    <style>
        .custom-button {
            display: inline-block;
            padding: 4px 8px;

            color: #ffffff;
            border-radius: 4px;
            text-decoration: none;
        }


    </style>
    <div class="block block-rounded mx-5">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Daftar Toko {{$user->name}}
            </h3>

        </div>
        <div class="block-content block-content-full">

            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60%;">Nama Toko</th>
                        <th style="width: 20%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($toko->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-primary">Tidak ada Toko</td>
                        </tr>
                    @endif
                    @foreach ($toko as $t)
                        <tr>
                            <td class="d-none d-sm-table-cell text-center">
                                {{ $t->name }}
                            </td>
                            <td class="text-center">
                                <a href="/dashboard/user/daftar-toko/{{ $user->name }}/detail/{{ $t->id }}" aria-hidden="true" class="btn-primary custom-button " style="display: inline-block;">
                                    <i class="fa-solid fa-circle-info fa-sm"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection



