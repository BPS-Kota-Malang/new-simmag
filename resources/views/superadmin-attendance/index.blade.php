@extends('layouts.app')

@section('script')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.print.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.2/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
<div class="container px-4 py-12 mx-auto">
    <div class="p-10 shadow-2xl bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
        <h2 class="mb-8 text-4xl font-bold text-center text-gray-800">Intern Attendances</h2>

        <div class="flex flex-col mb-4 space-y-4 md:flex-row md:space-x-4 md:space-y-0">
            <!-- Intern Name Filter -->
            <select id="intern-filter" class="w-full p-2 border rounded md:w-auto">
                <option value="">Piih Intern</option>
                <!-- Add division options dynamically or statically -->
                @foreach ( $interns as $intern )
                    <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                @endforeach
            </select>
        
        
            <!-- Division Filter -->
            <select id="division-filter" class="w-full p-2 border rounded md:w-auto">
                <option value="">Pilih Tim Kerja</option>
                <!-- Add division options dynamically or statically -->
                @foreach ( $divisions as $division )
                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                @endforeach
            </select>
        
            <!-- Month Filter -->
            <select id="month-filter" class="w-full p-2 border rounded md:w-auto">
                <option value="">Pilih Bulan</option>
                <!-- Add month options dynamically or statically -->
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
                <!-- Add remaining months -->
            </select>
        
        </div>

        <div class="relative overflow-x-auto overflow-y-auto max-h-[60vh] border border-gray-200 shadow-lg sm:rounded-lg">
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

        <div class="pt-8">
            <a href="{{ route('admin.attendance.export') }}" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">Export to Excel</a>
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
    const attendanceTable = $('#intern-attendance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.attendance.getData') }}', // Replace with your actual data URL
            data: function(d) {
                d.intern_id = $('#intern-filter').val();
                d.division = $('#division-filter').val();
                d.month = $('#month-filter').val();
            },
            
            // Prevent the initial draw
            dataSrc: function(json) {
                if (!$('#intern-filter').val() && !$('#division-filter').val() && !$('#month-filter').val()) {
                    return []; // No data until filters are applied
                }
                return json.data;
            }
        },
        columns: [
            { data: 'intern_name', name: 'intern_name' },
            { data: 'date', name: 'date' },
            { data: 'check_in', name: 'check_in' },
            { data: 'check_out', name: 'check_out' },
            { data: 'workhours', name: 'workhours' },
            { data: 'work_location', name: 'work_location' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        // Disable initial automatic search
        searching: false,
        
    });

     // Apply filter and redraw the table when filters change
    $('#intern-filter').on('change', function() {
        $('#division-filter').val(''); // Clear division filter when intern filter is applied
        attendanceTable.ajax.reload(); // Load data with the filters applied
    });

    $('#division-filter').on('change', function() {
        $('#intern-filter').val(''); // Clear intern filter when division filter is applied
        attendanceTable.ajax.reload(); // Load data with the filters applied
    });

    $('#month-filter').on('change', function() {
        attendanceTable.ajax.reload(); // Load data with the filters applied
    });

    $('#export-button').on('click', function(e) {
        e.preventDefault();

        // Collect filter parameters
        var filters = {
            intern_id: $('#intern-filter').val(),
            division: $('#division-filter').val(),
            month: $('#month-filter').val()
        };

        $.ajax({
            url: "{{ route('admin.attendance.export') }}",
            method: 'GET',
            data: filters,
            xhrFields: {
                responseType: 'blob' // Important for file download
            },
            success: function(response) {
                // Create a temporary link to trigger the download
                var link = document.createElement('a');
                var url = window.URL.createObjectURL(response);
                link.href = url;
                link.download = 'intern_attendance.xlsx';
                document.body.append(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function(response) {
                console.log('Error exporting data:', response);
            }
        });
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
