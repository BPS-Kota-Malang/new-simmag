@extends('layouts.app')
@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

@endsection

@section('content')
<div class="px-10 pt-20">
    <form action="{{ route('admin.email.send') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="interns" class="block text-sm font-medium text-gray-700">Select Interns</label>
            <div id="interns" class="block w-full p-2 mt-1 border border-gray-300">
                @foreach ($interns as $intern)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="intern_{{ $intern->id }}" name="interns[]" value="{{ $intern->id }}" class="mr-2">
                        <label for="intern_{{ $intern->id }}" class="text-sm">
                            {{ $intern->name }} ({{ $intern->user->email }})<br>
                            <span style="font-size: smaller;">Status: {{ $intern->work_status }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <textarea id="my-editor" name="content"></textarea>
        </div>


        <button type="submit" class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Send Email</button>
    </form>
</div>
@endsection
@section('javascript')
<script>
    let editorInstance;

    ClassicEditor
        .create(document.querySelector('#my-editor'))
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error('CKEditor initialization failed:', error);
        });

    document.querySelector('form').onsubmit = function(event) {
        // Ensure the editor data is passed in the textarea
        document.querySelector('#editor').value = editorInstance.getData();
    };
</script>
@endsection