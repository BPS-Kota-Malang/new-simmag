@extends('layouts.app')


@section('content')

<div class="container mt-8 mx-auto py-10 px-4 space-y-8">
    <div id="calendar" data-events-url="{{ route('logbooks.list') }}"></div>
</div>

<!-- Modal -->
<!-- Modal Wrapper -->
<div id="logbookModal" data-events-url="{{ route('logbooks.create') }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
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
@endsection