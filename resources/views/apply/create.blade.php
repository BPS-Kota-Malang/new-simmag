<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs" ></script> 
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js"></script> --}}
</head>
<body>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-6xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Pendaftaran Magang</h2>
            <form action="{{ route('interns.store') }}" method="POST" enctype="multipart/form-data">
                {{-- @if ($errors)
                    {{ dd($errors) }}
                @endif --}}
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ $user->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            disabled
                        />
                        <input type="hidden" name="name" value="{{ $user->name }}" />
                    </div>

                    <div class="w-full">
                        <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Induk Mahasiswa</label>
                        <input
                            type="text"
                            name="nim"
                            id="nim"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Masukkan Nomor Induk Mahasiswa anda"
                            required
                            value="{{ old('nim') }}"
                        />
                        @error('nim')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Handphone</label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Masukkan Nomor Handphone anda"
                            required
                            value="{{ old('phone') }}"
                        />
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                   
                    <div class="sm:col-span-2" x-data="searchableDropdown('university', '/searchUniversity', '/university')">
                        <label for="university_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Universitas</label>
                        <input
                            id="university_search"
                            type="text"
                            placeholder="Search for a university..."
                            x-model="searchQuery"
                            @input.debounce="searchItems"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                        />
                         <!-- Hidden input to store the selected university ID -->
                         <input type="hidden" name="university_id" x-model="selectedItemId">
                        <ul
                            x-show="items.length > 0"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
                        >
                            <template x-for="item in items" :key="item.id">
                                <li @click="selectItem(item)" class="p-2 hover:bg-gray-200" x-text="item.name"></li>
                            </template>
                        </ul>
                        <div x-show="items.length === 0 && searchQuery.length > 0 && !isItemSelected" class="mt-2">
                            <button @click.prevent="addItem" type="button" class="text-blue-500">Add new university: "<span x-text="searchQuery"></span>"</button>
                        </div>
                        <div x-text="'Items: ' + items.length + ', Query: ' + searchQuery"></div>
                    </div>

                    {{-- Faculty --}}
                    <div class="w-full" x-data="searchableDropdown('faculty', '/searchFaculty', '/faculty')">
                        <label for="faculty_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fakultas</label>
                        <input
                            id="faculty_search"
                            type="text"
                            placeholder="Search for a faculty..."
                            x-model="searchQuery"
                            @input.debounce="searchItems"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                        />

                         <!-- Hidden input to store the selected faculty ID -->
                        <input type="hidden" name="faculty_id" x-model="selectedItemId">

                        <ul
                            x-show="items.length > 0"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
                        >
                            <template x-for="item in items" :key="item.id">
                                <li @click="selectItem(item)" class="p-2 hover:bg-gray-200" x-text="item.name"></li>
                            </template>
                        </ul>
                        
                        <div x-show="items.length === 0 && searchQuery.length > 0 && !isItemSelected" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
                            <button @click.prevent="addItem" type="button" class="w-full p-2 text-blue-500 hover:bg-gray-100">
                                Add new university: "<span x-text="searchQuery"></span>"
                            </button>
                        </div>
                        <div x-text="'Items: ' + items.length + ', Query: ' + searchQuery"></div>
                    </div>

                    {{-- Department --}}
                    <div class="w-full" x-data="searchableDropdown('department', '/searchDepartment', '/department')">
                        <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                        <input
                            id="department_search"
                            type="text"
                            placeholder="Search for a department..."
                            x-model="searchQuery"
                            @input.debounce="searchItems"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                        />

                         <!-- Hidden input to store the selected department ID -->
                         <input type="hidden" name="department_id" x-model="selectedItemId">
                        <ul
                            x-show="items.length > 0"
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
                        >
                            <template x-for="item in items" :key="item.id">
                                <li @click="selectItem(item)" class="p-2 hover:bg-gray-200" x-text="item.name"></li>
                            </template>
                        </ul>
                        
                        <div x-show="items.length === 0 && searchQuery.length > 0 && !isItemSelected" class="text-left absolute z-10 relative mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
                            <button @click.prevent="addItem" type="button" class="w-full p-2 text-blue-500 hover:bg-gray-100">
                                Add new Department: "<span x-text="searchQuery"></span>"
                            </button>
                        </div>
                        <div x-text="'Items: ' + items.length + ', Query: ' + searchQuery"></div>
                    </div>


                    <div class="w-full">
                        <label for="file_proposal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Silahkan Upload File Proposal</label>
                        <input type="file" id="file_proposal" name="file_proposal" class="block w-full mb-4">
                        @error('file_proposal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="file_suratpengantar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Silahkan Upload File Surat Pengantar</label>
                        <input type="file" id="file_suratpengantar" name="file_suratpengantar" class="block w-full mb-4">
                        @error('file_suratpengantar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Silahkan Pilih Tanggal Mulai</label>
                        
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input 
                            id="start_date" 
                            name="start_date" 
                            datepicker 
                            datepicker-autohide 
                            type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
  
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="w-full">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Silahkan Pilih Tanggal Selesai</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input 
                            id="end_date" 
                            name="end_date" 
                            datepicker 
                            datepicker-autohide 
                            type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                        </div>
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                <button type="submit"
                    class="inline-flex sm:col-span-2 sm:text-left items-center justify-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Ajukan Permohonan Magang
                </button>
                
            </form>
        </div>
      </section>

    <script>
        function searchableDropdown(name, searchUrl, addUrl) {
            return {
                searchQuery: '',
                items: [],
                selectedItemId: null,
                isItemSelected: false,

                searchItems() {
                    fetch(`${searchUrl}?query=${this.searchQuery}`)
                        .then(response => response.json())
                        .then(data => {
                            this.items = data;
                            this.isItemSelected = false;
                        });
                },

                selectItem(item) {
                    this.searchQuery = item.name;
                    this.selectedItemId = item.id;
                    this.isItemSelected = true;
                    this.items = [];
                },

                addItem() {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(addUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ name: this.searchQuery })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        this.selectedItemId = data.id;
                        this.searchQuery = data.name;
                        this.isItemSelected = true;
                        this.items = [];
                    })
                    .catch(error => console.error('There has been a problem with your fetch operation:', error));
                }
            }
        }


    </script>

</body>
    
</html>