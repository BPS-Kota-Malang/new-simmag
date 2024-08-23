@extends('layouts.app')

{{-- @section('script')
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs" ></script> 
@endsection --}}
@section('content')

<div class="container mt-8 mx-auto py-10 px-4 space-y-8">
    <div id="calendar" data-events-url="{{ route('logbooks.list') }}"></div>
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