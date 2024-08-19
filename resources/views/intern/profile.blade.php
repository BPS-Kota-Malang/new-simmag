@extends('layouts.app')
@section('script')
<style>
    .profile-photo-container {
        width: 100px; /* or any desired width */
        height: 100px; /* or any desired height */
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ccc;
    }

    .profile-photo-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
@endsection
@section('content')

        <div class="container mx-auto p-8" x-data="{ editMode: false }">
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Display Status Message -->
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex flex-col md:flex-row items-center">
                    <div x-show="!editMode" class="profile-photo-container flex items-center mt-2">
                        <img class="w-40 h-40 md:w-48 md:h-48 rounded-full fit overflow-hidden border-4 border-gray-300" src="{{ Storage::url($intern->photo) }}" alt="Profile Photo">
                    </div>
                    <div x-show="editMode" class="mt-2">
                        <form action="{{ route('update_photo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" accept="image/*" class="mt-1 border rounded-lg p-2">
                            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none">Upload</button>
                        </form>
                    </div>
                    <div class="md:ml-8 mt-6 md:mt-0 text-center md:text-left">
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $intern->name }}</h2>
                        <p class="text-gray-600">{{ $intern->user->email }}</p>
                        <button @click="editMode = !editMode" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">
                            <span x-show="!editMode">Edit Profile</span>
                            <span x-show="editMode">Cancel</span>
                        </button>
                    </div>
                </div>
            </div>

    <form action="{{ route('interns.update', $intern->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Use PUT or PATCH if you're updating existing records -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                <div class="mt-4 space-y-2">
                    <div>
                        <label x-show="editMode" class="font-semibold text-gray-600">Nama:</label>
                        <input x-show="editMode" name="name" type="text" value="{{ $intern->name }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full">
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Email:</label>
                        <p>{{ $intern->user->email }}</p>
                        {{-- <input x-show="editMode" type="email" value="{{ $intern->user->email }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Jenis Kelamin:</label>
                        <p x-show="!editMode">{{ $intern->sex }}</p>
                        <select x-show="editMode" name="sex" id="sex">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>

                        {{-- <input x-show="editMode" type="email" value="{{ $intern->user->email }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Phone:</label>
                        <p x-show="!editMode">{{ $intern->phone }}</p>
                        <input x-show="editMode" name="phone" type="text" value="{{ old('phone', $intern->phone) }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full">
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Universitas:</label>
                        <p >{{ $intern->university->name }}</p>
                        {{-- <input x-show="editMode" type="text" value="{{ $intern->university->name }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Fakultas:</label>
                        <p >{{ $intern->faculty->name }}</p>
                        {{-- <input x-show="editMode" type="text" value="{{ $intern->faculty->name }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Jurusan:</label>
                        <p >{{ $intern->department->name }}</p>
                        {{-- <input x-show="editMode" type="text" value="{{ $intern->department->name }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                </div>
            </div>

            <!-- Internship Information -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800">Internship Information</h3>
                <div class="mt-4 space-y-2">
                    <div>
                        <label class="font-semibold text-gray-600">Start Date:</label>
                        <p >{{ $intern->start_date }}</p>
                        {{-- <input x-show="editMode" type="date" value="{{ $intern->start_date }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">End Date:</label>
                        <p >{{ $intern->end_date }}</p>
                        {{-- <input x-show="editMode" type="date" value="{{ $intern->end_date }}" class="mt-1 border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none w-full"> --}}
                    </div>
                </div>
            </div>
        </div>

         <!-- Save Button -->
        <div x-show="editMode" class="mt-6 text-right">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none">Save Changes</button>
        </div>
    </form>
@endsection
