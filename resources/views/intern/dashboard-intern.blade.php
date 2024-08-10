{{-- <x-app-layout> --}}
@extends('layouts.app')

@section('content')
    <x-slot name="header">
       
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Super Admin') }}
        </h2>
    </x-slot>
   
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
                                <div class="text-center">
                                    <!-- Congratulatory Message -->
                                    <h1 class="text-2xl font-bold text-green-600 mb-4">Congratulations!</h1>
                                    <p class="text-lg text-gray-700 mb-4">We are pleased to inform you that you have been accepted as an intern at our company.</p>
                                    
                                    <!-- Intern Details -->
                                    <div class="bg-green-100 p-4 rounded-lg mb-6">
                                        <h2 class="text-xl font-semibold text-green-800">Intern Details:</h2>
                                        <p class="text-gray-700 mt-2"><strong>Name:</strong> {{ $intern->name }}</p>
                                        {{-- <p class="text-gray-700"><strong>Position:</strong> {{ $internPosition }}</p> --}}
                                        {{-- <p class="text-gray-700"><strong>Start Date:</strong> {{ $startDate }}</p> --}}
                                    </div>
                                    
                                    <!-- Additional Information -->
                                    <p class="text-gray-700 mb-4">We are excited to have you join our team and look forward to your contributions. Further details will be shared with you soon.</p>
                                    <p class="text-gray-700">If you have any questions or need more information, please do not hesitate to contact us.</p>

                                    <!-- Call to Action Button -->
                                    <a href="{{ route('dashboard') }}" class="inline-block mt-6 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                                        Go to Dashboard
                                    </a>
                                </div>
                            </div>
                </div>
            </div>
        </div>

    <!-- In your Blade template -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
{{-- </x-app-layout> --}}
@endsection