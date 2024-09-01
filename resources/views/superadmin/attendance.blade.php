@extends('layouts.app')

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-10 rounded-xl shadow-2xl">
        <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">Intern Attendances</h2>

        <div class="mb-10 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div class="relative w-full md:w-1/3">
                <input type="text" id="search" placeholder="Search..." class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <svg class="absolute top-3 left-3 w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a7 7 0 014.468 12.264l4.379 4.379a1 1 0 01-1.415 1.415l-4.379-4.379A7 7 0 1111 4z" />
                </svg>
            </div>
            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <input type="text" id="start_date" placeholder="Start Date" class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <svg class="absolute top-3 left-3 w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v10M12 7v10M16 7v10" />
                    </svg>
                </div>
                <div class="relative w-full md:w-auto">
                    <input type="text" id="end_date" placeholder="End Date" class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    <svg class="absolute top-3 left-3 w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v10M12 7v10M16 7v10" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg border border-gray-200">
            <table id="intern-attendance-table" class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4">Intern Name</th>
                        <th scope="col" class="px-6 py-4">Date</th>
                        <th scope="col" class="px-6 py-4">Check In</th>
                        <th scope="col" class="px-6 py-4">Check Out</th>
                        <th scope="col" class="px-6 py-4">Work Hours</th>
                        <th scope="col" class="px-6 py-4">Work Location</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(document).ready(function() {
    var table = $('#intern-attendance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.attendance.getData") }}',
            data: function(d) {
                d.intern_name = $('#search').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            },
            type: 'GET',
        },
        columns: [
            { data: 'intern_name', name: 'intern_name' },
            { data: 'date', name: 'date' },
            { data: 'check_in', name: 'check_in' },
            { data: 'check_out', name: 'check_out' },
            { data: 'workhours', name: 'workhours' },
            { data: 'status', name: 'status' },
            { data: 'work_location', name: 'work_location' },
            { data: 'actions', name: 'actionsa', orderable: false, searchable: false }
        ],
        pagingType: "simple_numbers",
        dom: '<"flex justify-between items-center"<"ml-2"l><"mr-2"f>>rt<"flex justify-between items-center"<"ml-2"i><"mr-2"p>>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'bg-green-500 text-white px-4 py-2 rounded',
                action: function(e, dt, button, config) {
                    var divisionId = $('#internFilter').val(); // Assuming you're using a filter
                    window.location.href = `/attendance/export?division_id=${divisionId}`;
                }
            }
        ],
        language: {
            lengthMenu: "Show _MENU_ entries",
            search: "Search:",
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        }
    });

    $('#search').on('keyup', function() {
        table.search(this.value).draw();
    });
});

    
    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
    });

    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
    });
</script>
@endsection
