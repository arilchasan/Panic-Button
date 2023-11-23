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
        padding: 12px 16px;
        border: 1px solid #3490dc;
        background-color: #3490dc;
        color: #ffffff;
        border-radius: 4px;
        text-decoration: none;
    }

    .custom-button:hover {
        background-color: #2779bd;
    }

    .custom-icon {
        width: 40px;
        height: 40px;
        margin-right: 8px;
        vertical-align: middle;
    }
</style>
<div class="block block-rounded mx-5">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            Daftar Permissions
        </h3>
        <div class="">
            <a href="/dashboard/permission/create" class="btn btn-success ml-2 leading-2 px-3">+ Permissions</a>
        </div>
    </div>
    <div class="block-content block-content-full">
        @if (session()->has('success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h3 class="alert-heading fs-5 fw-bold mb-1">Success</h3>
                    <p class="mb-0">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="col-md-12">
                <!-- Danger Alert -->
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h3 class="alert-heading fs-5 fw-bold mb-1">Error</h3>
                    <p class="mb-0">
                        {{ session('errors') }}
                    </p>
                </div>
                <!-- END Danger Alert -->
            </div>
        @endif
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell">Nama Permissions</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Role</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Username Admin</th>
                    <th style="width: 20%;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($permissions->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-primary">Data User Kosong</td>
                    </tr>
                @endif
                @foreach ($permissions as $p)
                    <tr>
                        <td class="">{{ $p->name }}</td>
                        <td class="fw-semibold">
                            @if ($p->roles->count() > 0)
                                @foreach ($p->roles as $role)
                                    @if ($role->name == 'admin')
                                        <span class="badge" style="background-color: green">{{ $role->name }}</span>
                                    @elseif ($role->name === 'superadmin')
                                        <span class="badge"
                                            style="background-color: purple">{{ $role->name }}</span>
                                    @endif
                                @endforeach
                            @else
                                <span class="badge bg-danger">No Role Found :(</span>
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            @foreach ($role->users as $roles)
                                @if ($roles['name'] === 'admin')
                                    <span class="badge" style="background-color: green">{{ $roles['name'] }}</span>
                                @elseif ($roles['name'] === 'superadmin')
                                    <span class="badge" style="background-color: purple">{{ $roles['name'] }}</span>
                                @else
                                    {{ $roles['name'] }}
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="/dashboard/permission/edit/{{ $p->id }}" aria-hidden="true"
                                class="custom-button"
                                style="display: inline-block; padding: 12px 16px; border: 1px solid orange; background-color: orange; color: #ffffff; border-radius: 4px; text-decoration: none;">
                                <i class="fa-solid fa-pen-to-square fa-sm"></i>
                            </a>
                            <a onclick="deleteConfirmation({{ $p->id }})" aria-hidden="true"
                                class="custom-button"
                                style="display: inline-block; padding: 12px 16px; border: 1px solid red; background-color: red; color: #ffffff; border-radius: 4px; text-decoration: none;">
                                <i class="fa-solid fa-trash fa-sm"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/dashboard/permission/delete-permissions/" + id;
            }
        })
    }
</script>
<script>
    function closeAlert(alertId) {
        var alert = document.getElementById(alertId);
        if (alert) {
            alert.style.display = 'none';
        }
    }
</script>
