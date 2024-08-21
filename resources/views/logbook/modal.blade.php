<!-- resources/views/logbook/modal.blade.php -->

<div class="modal-header">
    <h5 class="text-lg font-semibold">Entry Log Book {{ $date }}</h5>
</div>
<div class="modal-body p-4">
    <form id="logbook-form">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        {{-- <input type="hidden" name="intern_id" value="{{ Auth::user()->id }}"> --}}
        <div class="mb-4">
            <label for="division_id" class="block text-sm font-medium">Tim Kerja</label>
            <select class="form-control mt-1 block w-full" id="division_id" name="division_id">
                @foreach ( $divisions as $div )
                    <option value="{{ $div->id }}">{{ $div->name }}</option> <!-- Populate with interns -->
                @endforeach
            </select>
        </div>
        {{-- <div class="mb-4">
            <label for="activity" class="block text-sm font-medium">Kegiatan</label>
            <input id="activity" name="activity" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"></textarea>
        </div> --}}

        <div class="sm:col-span-2 mb-4" x-data="searchableDropdown('/activity', '/searchActivity', '/activity')">
            <label for="activity_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kegiatan</label>
            <input
                id="activity_search"
                type="text"
                placeholder="Search for a activity..."
                x-model="searchQuery"
                @input.debounce="searchItems"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
            />
             <!-- Hidden input to store the selected activity ID -->
             <input type="hidden" name="activity_id" x-model="selectedItemId">
            <ul
                x-show="items.length > 0"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
            >
                <template x-for="item in items" :key="item.id">
                    <li @click="selectItem(item)" class="p-2 hover:bg-gray-200" x-text="item.name"></li>
                </template>
            </ul>
            <div x-show="items.length === 0 && searchQuery.length > 0 && !isItemSelected" class="mt-2">
                <button @click.prevent="addItem" type="button" class="text-blue-500">Add new Activity: "<span x-text="searchQuery"></span>"</button>
            </div>
            <div x-text="'Items: ' + items.length + ', Query: ' + searchQuery"></div>
        </div>

        <div class="mb-4">
            <label for="detail" class="block text-sm font-medium">Detail</label>
            <textarea id="detail" name="detail" rows="4" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"></textarea>
        </div>
        
        <div class="mb-4 flex space-x-4">
            <!-- Start Time -->
            <div class="w-1/2">
                <label for="time_start" class="block text-sm font-medium">Start Time</label>
                <input type="time" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300" id="time_start" name="time_start">
            </div>
            
            <!-- End Time -->
            <div class="w-1/2">
                <label for="time_end" class="block text-sm font-medium">End Time</label>
                <input type="time" class="form-control mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300" id="time_end" name="time_end">
            </div>
        </div>
        <div class="flex items-right mb-4">
            <input id="completedCheckbox" name="is_completed" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
            <label for="completedCheckbox" class="ms-2 text-sm font-medium text-gray-900">Kegiatan Sudah Selesai</label>

                    </div>
                    
                    <button type="submit" class="w-full py-2 mt-4 bg-blue-500 text-white rounded">Save Logbook</button>
                </form>
        </div>
