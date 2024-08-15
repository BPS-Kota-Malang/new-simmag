@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Attendance Report</h1>

    <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Filter Attendance</h2>
        <form id="filter-form" method="POST" action="">
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label for="intern" class="block text-sm font-medium text-gray-700">Intern</label>
                    <select id="intern" name="intern_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                        <option value="">Select Intern</option>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <input type="text" id="date_range" name="date_range" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
                </div>
                <!-- Additional filters can be added here -->
            </div>
            <div class="mt-4 text-right">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Apply Filters and Export as PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d"
        });
    </script>
@endpush
