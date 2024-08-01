@extends('layouts.app')
{{-- @include('components.app.sidebar') --}}
{{-- <x-app-layout> --}}
@section('script')
    <!-- Include Google Maps JavaScript API -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKCHmtQ7ylAsLWp67IbYKF_J4om4Gi8XA&libraries=geometry"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKCHmtQ7ylAsLWp67IbYKF_J4om4Gi8XA&callback=initMap" async defer></script>
@endsection

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Applicant') }}
        </h2>
    </x-slot>

    
    <button type="button" class="btn btn-primary" data-modal-target="attendanceModal" data-modal-toggle="attendanceModal">
        Mark Attendance
    </button>

    

    <div class="container mx-auto py-10 px-4 grid-flow-row">
        <form action="{{ route('attendance.mark') }}" method="POST">
            @csrf
            <input type="hidden" name="intern_id" value="{{ Auth::user()->intern->id }}">
            <button type="submit">Mark Attendance</button>
        </form>
        <div class="px-auto flex flex-row ">
            <div class="bg-red-100 w-1/2 text-center py-3 my-5">
                @if ($todayAttendance)
                    {{ $todayAttendance->check_in}}
                @else
                    -
                @endif
            </div>
            <div class="bg-gray-500 w-1/2 text-center py-3 my-5">
                @if ($todayAttendance)
                    {{ $todayAttendance->check_out}}
                @else
                    -
                @endif
            </div>
        </div>
        <div class="relative overflow-x-auto" >
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-s-lg">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 rounded-e-lg">
                            Check In
                        </th>
                        <th scope="col" class="px-6 py-3 rounded-e-lg">
                            Check Out
                        </th>
                        <th scope="col" class="px-6 py-3 rounded-e-lg">
                            Work Hours
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $a )
                    @if ($a->check_in)
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $a->date }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $a->check_in }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $a->check_out }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $a->workhours }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $a->work_location }}
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


   

<!-- Modal toggle -->
<button data-modal-target="attendanceModal" data-modal-toggle="attendanceModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
  </button>
  
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
                <form id="attendanceForm" action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="intern_id" value="{{ Auth::user()->intern->id }}">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="work_location" value="{{ $todayAttendance->work_location }}">
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
        let map, userMarker, officeCircle;
        const officeLat = parseFloat('{{ env('OFFICE_LATITUDE', -6.200000) }}');
        const officeLng = parseFloat('{{ env('OFFICE_LONGITUDE', 106.816666) }}');
        const officeLocation = { lat: officeLat, lng: officeLng };
        const RADIUS = 300; // Radius in meters
        let userLocation = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: officeLocation,
                zoom: 15
            });

            // Add the office marker
            new google.maps.Marker({
                position: officeLocation,
                map: map,
                title: 'Office Location'
            });

            // Add the office circle
            officeCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: officeLocation,
                radius: RADIUS // Radius in meters
            });

            // Get user location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showUserPosition, handleLocationError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showUserPosition(position) {
            userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };

            // Add user location marker
            userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Your Location'
            });

            // Center the map to the user location
            map.setCenter(userLocation);

            // Set hidden form fields
            document.getElementById('latitude').value = userLocation.lat;
            document.getElementById('longitude').value = userLocation.lng;
        }

        function handleLocationError(error) {
            alert("Error getting your location: " + error.message);
        }

        function haversineDistance(coords1, coords2) {
            const toRad = angle => angle * (Math.PI / 180);

            const lat1 = coords1.lat;
            const lon1 = coords1.lng;
            const lat2 = coords2.lat;
            const lon2 = coords2.lng;

            const R = 6371e3; // Earth radius in meters
            const φ1 = toRad(lat1);
            const φ2 = toRad(lat2);
            const Δφ = toRad(lat2 - lat1);
            const Δλ = toRad(lon2 - lon1);

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // Distance in meters
        }

        function checkDistance(userLocation) {
            const distance = haversineDistance(officeLocation, userLocation);
            console.log('Distance to office:', distance);

            if (distance > RADIUS) {
                alert("You are out of the allowable range to mark attendance.");
                return false;
            } 
            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('saveAttendance').addEventListener('click', function(event) {
                const workLocation = document.getElementById('work_location').value;

                if (workLocation === 'office') {
                    if (!userLocation) {
                        alert("Could not determine your location.");
                        event.preventDefault();
                        return;
                    }
                    if (!checkDistance(userLocation)) {
                        event.preventDefault();
                        return;
                    }
                }

                document.getElementById('attendanceForm').submit();
            });

            $('#attendanceModal').on('shown.bs.modal', function () {
                google.maps.event.trigger(map, 'resize');
                initMap();
            });
        });
    </script>
    
    @endsection
@endsection