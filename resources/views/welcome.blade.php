<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        @vite(['resources/css/app.css','resources/js/app.js'])
        <!-- Styles -->
        <style>
            
        </style>
    </head>
    <body class="antialiased">
      <section class="bg-[url({{ asset('/storage/img/Cover.jpg') }}] bg-cover bg-center bg-no-repeat">
        
          <div
            class="absolute inset-0 bg-gray-900/75 sm:bg-transparent sm:from-gray-900/95 sm:to-gray-900/25 ltr:sm:bg-gradient-to-r rtl:sm:bg-gradient-to-l"
          ></div>

          <div
            class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-6 lg:flex lg:h-screen lg:items-center lg:px-8"
          >
            <div class="max-w-xl text-center ltr:sm:text-left rtl:sm:text-right">
              <h1 class="text-3xl font-extrabold text-white sm:text-5xl">
                Sistem Manajemen
                <strong class="block font-extrabold text-orange-500"> Magang</strong>
              </h1>
              <p class="mt-4 max-w-lg text-white sm:text-xl/relaxed">
                  Menghubungkan Data dengan Talenta Muda
              </p>

              <div class="mt-8 flex flex-wrap gap-4 text-center">
                <a
                  href="/login"
                  class="block w-full rounded bg-orange-600 px-12 py-3 text-sm font-medium text-white shadow hover:bg-orange-700 focus:outline-none focus:ring active:bg-orange-500 sm:w-auto"
                >
                  Login
                </a>

                {{-- <a
                  href="#"
                  class="block w-full rounded bg-white px-12 py-3 text-sm font-medium text-orange-600 shadow hover:text-orange-700 focus:outline-none focus:ring active:text-orange-500 sm:w-auto"
                >
                  Learn More
                </a> --}}
              </div>
            </div>
          </div>
        </section>  
    </body>
</html>
