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
        
        <button type="submit" class="w-full py-2 mt-4 bg-blue-500 text-white rounded">Save Logbook</button>
    </form>
</div>
