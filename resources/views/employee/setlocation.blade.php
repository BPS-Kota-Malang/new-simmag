@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Bulk Set Work Location</h2>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.bulkSetWorkLocation') }}" method="POST" class="space-y-8">
            @csrf

            <div>
                <label for="intern_ids" class="block text-lg font-medium text-gray-700 mb-2">Select Interns</label>
                <select name="intern_ids[]" id="intern_ids" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
                    @foreach($interns as $intern)
                        <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="dates" class="block text-lg font-medium text-gray-700 mb-2">Select Dates</label>
                <input type="date" name="dates[]" id="dates" class="mt-1 block w-full py-2 text-base border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" multiple required>
            </div>

            <div>
                <label for="work_location" class="block text-lg font-medium text-gray-700 mb-2">Select Work Location</label>
                <select name="work_location" id="work_location" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="office">Office</option>
                    <option value="home">Home</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Set Work Location
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
