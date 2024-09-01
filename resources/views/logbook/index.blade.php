@extends('layouts.app')

{{-- @section('script')
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs" ></script> 
@endsection --}}
@section('content')

<div class="container mt-8 mx-auto py-10 px-4 space-y-8" >
    @if ( Auth::user()->hasRole('Super Admin') )
        <!-- Your calendar and filter UI here -->
        <div class="container mx-auto mt-6">
            <div class="flex items-center justify-between">
                <div class="w-1/3">
                    <label for="internFilter" class="block text-sm font-medium text-gray-700">Select Intern</label>
                    <select id="internFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div class="ml-4">
                    <button id="applyFilter" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div    id="calendar" 
            data-events-url="{{ route('logbooks.list') }}"
            data-intern-url="{{ route('api.intern.active') }}"
            data-division-url="{{ route('api.division') }}"
    >
    </div>
</div>

<!-- Modal -->
<!-- Modal Wrapper -->
<div id="logbookModal" data-events-url="{{ route('logbooks.create') }}" data-event-edit-url="{{ url('logbooks') }}"  data-patch-url="{{ url('logbooks/') }}"class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg lg:w-1/3 w-full">
      <div id="modal-content" class="p-6">
        <!-- Content will be loaded here via AJAX -->
      </div>
    </div>
</div>

@vite('resources/js/calendar.js')
  
@endsection`

@section('javascript')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs" ></script> 
    <script>
      function searchableDropdown(name, searchUrl, addUrl, initialActivityId = null, initialSelectedItemName = '', initialSelectedItemDetail='') {
        console.log("Initial Values:", {
            name,
            searchUrl,
            addUrl,
            initialActivityId,
            initialSelectedItemName,
            initialSelectedItemDetail
    });

        return {
            searchQuery: initialSelectedItemName,
            division_id: '',
            items: [],
            selectedItemId: initialActivityId,
            detail: initialSelectedItemDetail,
            isItemSelected: initialActivityId !== null,
        
            searchItems() {
                const divisionSelect = document.getElementById('division_id');
                const selectedDivisionId = divisionSelect.value;
                // Construct the URL with the query and division_id parameters
                const url = `${searchUrl}?query=${this.searchQuery}&division_id=${selectedDivisionId}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        this.items = data;
                        this.isItemSelected = false;
                    });
        },

            selectItem(item) {
                this.searchQuery = item.name;
                this.division_id = item.division_id;
                this.selectedItemId = item.id;
                this.isItemSelected = true;
                this.items = [];
            },

            addItem() {
                const divisionSelect = document.getElementById('division_id');
                const selectedDivisionId = divisionSelect.value;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(addUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ 
                        name: this.searchQuery , 
                        division_id: selectedDivisionId ,
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    this.selectedItemId = data.id;
                    this.searchQuery = data.name;
                    this.isItemSelected = true;
                    this.items = [];
                })
                .catch(error => console.error('There has been a problem with your fetch operation:', error));
            }
          }
      }


  </script>
@endsection