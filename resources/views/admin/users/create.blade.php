@extends('layouts.app')
@section('title', 'Crear Usuario')

@section('content')
  <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
    <div class="flex justify-between py-2">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Usuarios
      </h2>
    </div>
  
    <div class="max-w-4xl mx-auto bg-gray-50 rounded shadow-md shadow-blue-600">
      @if (isset($errors) && $errors->any())
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      @endif

      @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
          {{ session()->get('error') }}
        </div>
      @endif

      @if ($message = Session::get('success'))
        <div class="bg-green-100 mb-4 px-5 py-4 w-full border-l-4 border-green-500">
          <div class="flex justify-between">
            <div class="flex space-x-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="flex-none fill-current text-green-500 h-4 w-4">
                <path
                  d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 16.518l-4.5-4.319 1.396-1.435 3.078 2.937 6.105-6.218 1.421 1.409-7.5 7.626z" />
              </svg>
              <div class="flex-1 leading-tight text-sm text-green-700 font-medium">{{ $message }}</div>
            </div>
          </div>
        </div>
      @endif

      <div class="p-10">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label for="">Subir imagen</label>
            <input type="file" name="image" class="form-control">
          </div>

          @include('admin.users._fields')

          <div class="pt-10 bg-gray-50 text-center space-y-2">
            <button type="submit" class="inline-flex items-center justify-center w-28 px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
              <i class="fa-solid fa-list-ol mr-2"></i>Cancelar
            </button>
    
            <button type="reset" class="inline-flex items-center justify-center w-28 px-2 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
              <i class="fa-solid fa-eraser mr-2"></i>Limpiar
            </button>
    
            <button type="submit" id="save" class="inline-flex items-center justify-center w-28 px-2 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
              <i class="fa-solid fa-save mr-2"></i>
              {{ isset($user->id) ? 'Actualizar' : 'Crear'}}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('scripts')
  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

  <script>
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    FilePond.setOptions({
    server: {
        process:  '{{ route('tempUplaod') }}', // '/temp-upload',
        revert:   '{{ route('tempDelete') }}', //'/temp-delete',
        headers:{
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
      }
    });
  </script>
@endpush
