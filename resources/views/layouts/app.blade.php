<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png"/>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

            <!-- Styles -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        {{-- @livewireStyles         --}}
        @yield('script')
        <script>
            if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.remove('dark');
                document.querySelector('html').style.colorScheme = 'light';
            } else {
                document.querySelector('html').classList.add('dark');
                document.querySelector('html').style.colorScheme = 'dark';
            }
        </script>
    </head>
    <body
        class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"    
    >

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-[100dvh] overflow-hidden">
            @include('layouts.navigation')
            @include('layouts.sidebar')
                <main class="p-1 w-full md:ml-64 h-auto pt-4">
                    @yield('content')
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </main>
            @if (Auth::user()->hasAnyRole(['user', 'applicant']))
                @include('layouts.footer')
            @endif
        </div>
        @yield('javascript')
    </body>
</html>
