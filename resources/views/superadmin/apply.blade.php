@extends('layouts.app')

@section('content')
<div class="container w-full px-4 py-12">
    <div class="mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Intern Applies</h2>

        <div class="mb-8 flex items-center justify-between">
            <div class="relative w-full max-w-xs">
                <input type="text" id="search" placeholder="Search..." class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <svg class="absolute top-2 left-3 w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a7 7 0 014.468 12.264l4.379 4.379a1 1 0 01-1.415 1.415l-4.379-4.379A7 7 0 1111 4z" />
                </svg>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="intern-applicant-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Universitas</th>
                        <th scope="col" class="px-6 py-3">Fakultas</th>
                        <th scope="col" class="px-6 py-3">Jurusan</th>
                        <th scope="col" class="px-6 py-3">File Proposal</th>
                        <th scope="col" class="px-6 py-3">File Pengantar</th>
                        <th scope="col" class="px-6 py-3">Tanggal Pengajuan Magang</th>
                        <th scope="col" class="px-6 py-3">Tanggal Magang</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
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
<script>
$(document).ready(function() {
    var table = $('#intern-applicant-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.apply.getData") }}',
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
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        pagingType: "simple_numbers",
        dom: '<"flex justify-between items-center"<"ml-2"l><"mr-2"f>>rt<"flex justify-between items-center"<"ml-2"i><"mr-2"p>>',
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
</script>
@endsection
