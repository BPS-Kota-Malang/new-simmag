<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <body>
        <main class="p-1 w-full md:ml-4 h-auto pt-4">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if ($intern->work_status == 'on progress')
                            <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
                                <div class="text-center">
                                    <h1 class="text-2xl font-bold text-blue-600 mb-4">Application Status</h1>
                                    <p class="text-lg text-gray-700 mb-4">{{ "Halo {$intern->name } ! Terima kasih atas minat Anda untuk bergabung dengan tim kami. Kami saat ini sedang meninjau pengajuan magang Anda dan akan memberitahukan Anda setelah proses selesai."}}</p>
                
                                    @if ($apply->start_date_answer)
                                        <div class="bg-blue-100 p-4 rounded-lg mb-6 text-center">
                                            <p class="text-lg font-semibold text-blue-800 mb-2">
                                                Tanggal tersebut penuh, apakah Anda bersedia magang pada tanggal {{ $apply->start_date_answer }} hingga {{ $apply->end_date_answer }}?
                                            </p>
                                            <div class="flex justify-center space-x-4">
                                                <a href="{{ route('apply.accepted', ['id' => $intern->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Baik, Saya Setuju
                                                </a>
                                                <a href="{{ route('apply.rejected', ['id' => $intern->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    Tidak, Saya Tidak Setuju
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            'Rejected'
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>

