{{-- <x-app-layout> --}}
@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pendaftar') }}
        </h2>
    </x-slot>

    <!-- component -->
    <!-- Main container -->
    <section class="container mx-auto px-4 py-10">
        <div class="flex flex-col">

            <!-- Table Container -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 bg-white border border-gray-200 rounded-lg">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="checkbox-all" class="sr-only">Select All</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">Nama</th>
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
                        @foreach ($applies as $apply)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-{{ $apply->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="checkbox-table-{{ $apply->id }}" class="sr-only">Select</label>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $apply->intern->name }}</td>
                            <td class="px-6 py-4">{{ $apply->intern->university }}</td>
                            <td class="px-6 py-4">{{ $apply->intern->faculty }}</td>
                            <td class="px-6 py-4">{{ $apply->intern->courses }}</td>
                            <td class="px-6 py-4">{{ $apply->intern->file_proposal }}</td>
                            <td class="px-6 py-4">{{ $apply->intern->file_suratpengantar }}</td>
                            <td class="px-6 py-4">{{ $apply->start_date_apply . " - " . $apply->end_date_apply }}</td>
                            <td class="px-6 py-4">
                                @if ($apply->start_date_answer)
                                    {{ $apply->start_date_answer . " - " . $apply->end_date_answer }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="text-blue-600 hover:text-blue-800">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('apply.accepted', ['id' => $apply->intern->id]) }}" class="text-green-600 hover:text-green-800 mx-2">
                                    <i class="fa fa-check-square"></i>
                                </a>
                                <a href="{{ route('apply.rejected', ['id' => $apply->intern->id]) }}" class="text-red-600 hover:text-red-800">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                <div class="relative w-full max-w-lg mx-auto bg-white rounded-lg shadow-lg">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Tanggal Pengajuan</h3>
                        <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-2 absolute top-2 right-2" data-modal-toggle="crud-modal">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6m-6-6l6-6m-6 6L1 7" />
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    <form action="{{ route('apply.update', ['apply' => $apply->id]) }}" method="POST" class="p-4">
                        @csrf
                        @method('patch')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div>
                                <label for="start_date_answer" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date_answer" id="start_date_answer" value="{{ old('start_date_answer') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('start_date_answer')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="end_date_answer" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date_answer" id="end_date_answer" value="{{ old('end_date_answer') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                @error('end_date_answer')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
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
        </div>
    </section>
@endsection
{{-- </x-app-layout> --}}
