@extends('layouts.app')
{{-- @include('components.app.sidebar') --}}
{{-- <x-app-layout> --}}
@section('script')
    <!-- Include Google Maps JavaScript API -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKCHmtQ7ylAsLWp67IbYKF_J4om4Gi8XA&libraries=geometry"></script> --}}
    {{-- <script src="{{ 'https://maps.googleapis.com/maps/api/js?key='{env('OFFICE_LATITUDE')}'&callback=initMap}}'" async defer></script> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endsection

@section('content')
<!-- Main container -->
<div class="container mt-8 mx-auto py-10 px-4 space-y-8">
    <div>
        <button type="button" data-modal-target="attendanceModal" data-modal-toggle="attendanceModal" class="btn btn-primary bg-green-600 text-white hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
            Mark Attendance
        </button>
    </div>
    

    <!-- Attendance status -->
    <div class="flex space-x-4">
        <div class="bg-red-100 w-full md:w-1/2 text-center py-3 rounded-lg shadow-md">
            @if ($todayAttendance)
                <span class="text-red-600">{{ $todayAttendance->check_in }}</span>
            @else
                <span class="text-gray-500">-</span>
            @endif
        </div>
        <div class="bg-gray-100 w-full md:w-1/2 text-center py-3 rounded-lg shadow-md">
            @if ($todayAttendance)
                <span class="text-gray-600">{{ $todayAttendance->check_out }}</span>
            @else
                <span class="text-gray-500">-</span>
            @endif
        </div>
    </div>

    <!-- Attendance table -->
    <div class="relative overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 hidden md:table-cell text-center">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Check In
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Check Out
                    </th>
                    <th scope="col" class="px-6 py-3 hidden text-center md:table-cell">
                        Work Hours
                    </th>
                    <th scope="col" class="px-6 py-3 hidden text-center md:table-cell">
                        Work Location
                    </th>
                    <th scope="col" class="px-6 py-3 hidden text-center md:table-cell">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $a)
                    @if ($a->check_in)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center hidden md:table-cell">
                            {{ $a->date }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $a->check_in }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $a->check_out }}
                        </td>
                        <td class="px-6 py-4 hidden text-center md:table-cell">
                            {{ $a->workhours }}
                        </td>
                        <td class="px-6 py-4 hidden text-center md:table-cell">
                            {{ $a->work_location }}
                        </td>
                        <td class="px-6 py-4 hidden text-center md:table-cell">
                            {{ $a->status }}
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    
    


    <!-- In your Blade template -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Modal Structure -->
    <div id="customAlert" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <h2 class="text-xl font-semibold text-gray-800">Oops!</h2>
                    <p class="mt-2 text-gray-600">Anda diharuskan WFO, Tidak dapat melakukan </p>
                    <div class="mt-4 flex justify-end">
                        <button id="closeAlertBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">OK</button>
                    </div>
                </div>
    </div>
  
  <!-- Main modal -->
  <div id="attendanceModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Simpan Kehadiran
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="attendanceModal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div id="map" style="height: 400px; width: 100%;"></div>
                <form id="attendanceForm" action="{{ route('attendance.mark') }}" method="POST">
                    @csrf
                    <input type="hidden" name="intern_id" value="{{ Auth::user()->intern->id }}">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    @if ($todayAttendance)
                        <input type="hidden" name="work_location" id="work_location" value="{{ $todayAttendance->work_location }}">
                    @else
                        <input type="hidden" name="work_location" id="work_location" value="office">
                    @endif
                    
                    {{-- handle error belum assign --}}
                    <!-- other fields as needed -->
                </form>
              <!-- Modal footer -->
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button id="saveAttendance" data-modal-hide="attendanceModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                  <button data-modal-hide="attendanceModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
              </div>
          </div>
      </div>    
  </div>

  
  

    @section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([{{ env('OFFICE_LATITUDE') }}, {{ env('OFFICE_LONGITUDE') }}], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var officeLocation = L.marker([{{ env('OFFICE_LATITUDE') }}, {{ env('OFFICE_LONGITUDE') }}]).addTo(map)
        .bindPopup('Office Location')
        .openPopup();

    var officeCircle = L.circle([{{ env('OFFICE_LATITUDE') }}, {{ env('OFFICE_LONGITUDE') }}], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 300
    }).addTo(map);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = [position.coords.latitude, position.coords.longitude];
            var userMarker = L.marker(userLocation).addTo(map)
                .bindPopup('Your Location')
                .openPopup();
            map.setView(userLocation, 15);

            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

            checkDistance(userLocation);
        }, function(error) {
            alert("Error getting your location: " + error.message);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function showAlert() {
        document.getElementById('customAlert').classList.remove('hidden');
        document.getElementById('attendanceModal').classList.add('hidden');
    }

    document.getElementById('closeAlertBtn').addEventListener('click', function() {
        document.getElementById('customAlert').classList.add('hidden');
    });

    function checkDistance(userLocation){
        document.getElementById('saveAttendance').addEventListener('click', function() {
        const workLocation = document.getElementById('work_location').value;
        if (workLocation === 'office') {
            const userLat = parseFloat(document.getElementById('latitude').value);
            const userLng = parseFloat(document.getElementById('longitude').value);
            const officeLatLng = L.latLng({{ env('OFFICE_LATITUDE') }}, {{ env('OFFICE_LONGITUDE') }});
            const userLatLng = L.latLng(userLat, userLng);
            const distance = officeLatLng.distanceTo(userLatLng);

            if (distance > 300) {
                // alert('BROOO ABSEN DIKANTORRR!!!');
                showAlert();
                return;
            }
        }
        document.getElementById('attendanceForm').submit();
    });
    }
   
});

    </script>
    
    @endsection
@endsection