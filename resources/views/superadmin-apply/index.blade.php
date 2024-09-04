@extends('layouts.app')

@section('content')
<div class="container w-full px-4 py-12">
    <div class="p-8 mx-auto bg-white rounded-lg shadow-lg">
        <h2 class="mb-8 text-3xl font-semibold text-gray-800">Intern Applies</h2>

        <div class="flex items-center justify-between mb-8">
            <div class="relative w-full max-w-xs">
                <input type="text" id="search" placeholder="Search..." class="block w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <svg class="absolute w-5 h-5 text-gray-500 top-2 left-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a7 7 0 014.468 12.264l4.379 4.379a1 1 0 01-1.415 1.415l-4.379-4.379A7 7 0 1111 4z" />
                </svg>
            </div>
        </div>

        <div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg">
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
                        <th scope="col" class="px-6 py-3">Tanggal Pendaftaran Magang</th>
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

    <!-- Modal Edit Causes -->
    <div id="edit-date-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="relative w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Edit Tanggal Pengajuan</h3>
                <button type="button" class="absolute p-2 text-sm text-gray-400 rounded-lg hover:bg-gray-200 hover:text-gray-900 top-2 right-2" data-modal-toggle="edit-date-modal">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6m-6-6l6-6m-6 6L1 7" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <form action="" method="POST" class="p-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="start_date_answer" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date_answer" id="start_date_answer" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        @error('start_date_answer')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date_answer" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date_answer" id="end_date_answer" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        @error('end_date_answer')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-600 bg-opacity-50">
        <div class="w-1/3 p-5 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Reject Application</h2>
            <form action="" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="apply_id">
                <div class="mb-4">
                    <label for="causes" class="block text-gray-700">Cause of Rejection:</label>
                    <textarea name="causes" id="causes" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 mr-2 text-white bg-gray-400 rounded close-modal">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded">Reject</button>
                </div>
            </form>
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
            { data: 'status', name: 'status' },
            { data: 'university', name: 'university' },
            { data: 'faculty', name: 'faculty' },
            { data: 'department', name: 'department' },
            { data: 'proposal', name: 'proposal' },
            { data: 'pengantar', name: 'pengantar' },
            { data: 'registration_date', name: 'registration_date' },
            { data: 'apply_date', name: 'apply_date', className: 'text-center' },
            { data: 'answer_date', name: 'answer_date' , className: 'text-center'},
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

    // Handle the click event for edit buttons
    $('#intern-applicant-table').on('click', '.edit-btn', function(event) {
        event.preventDefault();

        // Get data from attributes
        const id = $(this).data('id');
        const startDateAnswer = $(this).data('start-date-answer');
        const endDateAnswer = $(this).data('end-date-answer');

        // Set data to modal fields
        $('#edit-date-modal form').attr('action', '/apply/' + id); // Adjust URL if needed
        $('#start_date_answer').val(startDateAnswer);
        $('#end_date_answer').val(endDateAnswer);

        // Show the modal
        $('#edit-date-modal').removeClass('hidden');
    });
    

    $('#intern-applicant-table').on('click', '.reject-btn', function(event) {
        event.preventDefault();

        // Get the apply ID from the clicked button's data-id attribute
        const id = $(this).data('id');

        // Update the form's action attribute to include the apply ID in the URL
        $('#reject-modal form').attr('action', '/apply/rejected/' + id);

        // Optionally set the hidden input value (if used in the backend)
        $('#reject-modal form input[name="apply_id"]').val(id);

        // Show the modal
        $('#reject-modal').removeClass('hidden');
    });

    $('#search').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Handle the close button click
    $('[data-modal-toggle="edit-date-modal"]').on('click', function() {
        $('#edit-date-modal').addClass('hidden');
    });

    
});
</script>
@endsection
