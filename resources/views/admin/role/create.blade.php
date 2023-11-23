@extends('layouts.backend')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />

    <style>
        .option-checkbox:checked + label {
            background-color: #6379e8;
            color: white;
        }
    </style>

    <section class="w-auto p-5 mx-5 my-2 rounded-md shadow-md" style="height: 75vh">
        <h2 class="text-lg font-semibold  apitalize ">Tambah Role</h2>

        <form action="/dashboard/role/add-role" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="" for="name">Nama Role</label>
                    <input id="name" type="text" name="name" placeholder="Admin"
                        class="w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-red-500 focus:outline-none-red focus:ring-0">
                </div>
                {{-- <div>
                    <label for="guard_name" class="">Nama Guard</label>
                    <select id="guard_name" name="guard_name"
                        class="w-full mt-2 px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-red-500 focus:ring-0">
                        <option value="admin">Admin</option>
                    </select>
                </div> --}}
                <input type="hidden" value="admin" name="guard_name">
                {{-- <div>
                    <label for="permissions" class="">Pilih Permissions:</label>
                    @foreach ($permissions as $item)
                        <div class="flex items-center mt-2">
                            <input type="checkbox" id="{{ $item->name }}" name="permissions[]" value="{{ $item->name }}"
                                class="h-4 w-4 text-blue-600 bg-white-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-white-800 focus:ring-2 dark:bg-white-700 dark:border-white-600"
                                @if ($item->name)  @endif>
                            <label for="{{ $item->name }}"
                                class="ml-2 text-sm ">{{ $item->name }}</label>
                        </div>
                    @endforeach
                </div> --}}
                <div class="relative text-left">
                    <label for="permissions" class="mb-2">Pilih Permissions</label>
                    <div>
                        <div id="selected-options-container" class="flex flex-wrap"></div>
                        <button type="button" onclick="toggleDropdown()"
                            class="inline-flex justify-between w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                            id="selected-options-container" aria-haspopup="true" aria-expanded="true">
                            Pilih Permissions
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10.293 14.95a1 1 0 0 1-1.414 0l-4.242-4.243a1 1 0 0 1 1.414-1.414L10 12.586l3.536-3.537a1 1 0 0 1 1.414 1.414l-4.243 4.243z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div id="dropdown"
                        class="origin-top-left absolute mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y hidden"
                        role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="">
                            <div class="flex items-center text-center">
                                <input type="checkbox" id="select-all" name="select_all" onchange="selectAllCheckbox(this)"
                                    class="sr-only option-checkbox" value="">
                                <label for="select-all" class="text-sm font-medium w-full p-2 text-left text-grey-700 bg-white-100 border-gray-300 option-label hover:bg-gray-200">Select All</label>
                            </div>
                            @foreach ($permissions as $item)
                                <div class="flex items-center text-center">
                                    <input type="checkbox" id="{{ $item->name }}" name="permissions[]"
                                        value="{{ $item->name }}" class="hidden option-checkbox">
                                    <label for="{{ $item->name }}"
                                        class="text-sm font-medium w-full p-2 text-left text-grey-700 bg-white-100 border-gray-300 option-label hover:bg-gray-200">{{ $item->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>



                    <div class="flex flex-col md:flex-row justify-end mt-9">
                        <a href="/dashboard/role/all" class="btn btn-secondary ml-2 leading-5 px-6 py-2 mt-2 md:mt-0">Kembali</a>
                        <button type="submit"
                        class="px-6 py-2 ml-2 leading-5 text-white transition-colors duration-200  bg-red-700 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600 mt-2 md:mt-0">Simpan</button>
                    </div>

                </div>
            </div>
        </form>
    </section>
@endsection
<script>
    function toggleDropdown() {
        let dropdown = document.getElementById('dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
        document.querySelectorAll('input[type=checkbox]').forEach(item => {
            item.addEventListener('change', (event) => {
                showSelectedOptions();
            });
        });
    }

    let checkboxStatus = {};

    function selectAllCheckbox(source) {
        const checkboxes = document.querySelectorAll('input[type=checkbox]:not(#select-all)');
        checkboxes.forEach(checkbox => {
            if (checkbox !== source) {
                checkbox.checked = source.checked;
                checkboxStatus[checkbox.id] = source.checked;
            }
        });
        showSelectedOptions();
    }

    function showSelectedOptions() {
        const selectedOptions = Array.from(
            document.querySelectorAll('input[type=checkbox]:checked'),
            option => option.value
        );
        const selectedOptionsContainer = document.getElementById('selected-options-container');
        selectedOptionsContainer.innerHTML = '';
        if (selectedOptions.length > 0) {
            selectedOptions.forEach(option => {
                if (option !== '') {
                    const span = document.createElement('span');
                    span.innerText = option;
                    span.classList = 'bg-gray-200 text-gray-800 px-2 py-1 rounded mr-2 mb-2 flex items-center';
                    const closeButton = document.createElement('button');
                    closeButton.innerText = 'x';
                    closeButton.classList = 'ml-2 text-sm font-bold focus:outline-none';
                    closeButton.addEventListener('click', () => {
                        const optionCheckbox = document.querySelector(
                            `input[type=checkbox][value="${option}"]`);
                        if (optionCheckbox) {
                            optionCheckbox.checked = false;
                            optionCheckbox.dataset.checked = "false";
                        }
                        showSelectedOptions();
                    });
                    span.appendChild(closeButton);
                    selectedOptionsContainer.appendChild(span);
                }
            });
        }
    }
</script>
