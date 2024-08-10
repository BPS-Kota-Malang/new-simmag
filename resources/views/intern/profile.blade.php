@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-10 p-5">
        <!-- Profile Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex justify-center p-5 bg-gradient-to-r from-blue-500 to-purple-600">
                <div class="rounded-full bg-white border-4 border-white w-32 h-32 overflow-hidden">
                    {{-- <img src="{{ $intern->profile_picture_url }}" alt="Profile Picture" class="object-cover w-full h-full"> --}}
                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png" alt="Profile Picture" class="object-cover w-full h-full">
                </div>
            </div>
            <div class="p-5">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $intern->name }}</h1>
                    {{-- <p class="text-gray-500">{{ $intern->role }}</p> --}}
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800">Personal Information</h2>
                        <div class="mt-4">
                            <p><strong>Email:</strong> {{ $intern->user->email }}</p>
                            <p><strong>Phone:</strong> {{ $intern->phone }}</p>
                            <p><strong>Universitas:</strong> {{ $intern->university }}</p>
                            <p><strong>Fakultas:</strong> {{ $intern->faculty }}</p>
                            <p><strong>Jurusan:</strong> {{ $intern->courses }}</p>
                        </div>
                    </div>
                    <!-- Internship Information -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-800">Internship Information</h2>
                        <div class="mt-4">
                            <p><strong>Start Date:</strong> {{ $intern->start_date }}</p>
                            <p><strong>End Date:</strong> {{ $intern->end_date }}</p>
                            {{-- <p><strong>Department:</strong> {{ $intern->department }}</p> --}}
                        </div>
                    </div>
                </div>
                <!-- Additional Information -->
                <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-6">
                    <h2 class="text-xl font-semibold text-gray-800">Additional Information</h2>
                    <div class="mt-4">
                        <p><strong>Skills:</strong> </p>
                        <p><strong>Projects:</strong> </p>
                        <p><strong>Notes:</strong> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
