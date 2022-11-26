@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
  <div class="flow-root w-full mx-auto shadow bg-white rounded">
      <form  action="{{route('users.search')}}" method ="POST">
        @csrf

        <div class="grid grid-cols-6 gap-x-10 gap-y-8">
          <div class="col-span-6 sm:col-span-3">
            <div class="relative form-group">
              <label for="names" class='absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm'>
                Nombres
              </label>
              <input type="text" class="f-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black" id="names" name="names"/>
            </div>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <div class="relative form-group">
              <label for="surnames" class='absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm'>
                Apellidos
              </label>
              <input type="text" class="f-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black" id="surnames" name="surnames"/>
            </div>
          </div>
        </div>

        <div class="py-4">
          <button type='submit' class='inline-flex items-center justify-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition' name="search">
            <i class="fa-solid fa-magnifying-glass mr-2"></i>Filtrar
          </button>
        </div>
      </form>

      <div class="px-4 py-4">
        @if ($users->count())
          @include('users._table')
        @else
          <div class="flex justify-center px-4 mt-14 mb-2 space-x-4 text-green-600">
            No hay registros creados
          </div>
        @endif
      </div>
    </div>
  @endsection

  @push('scripts')
    {{-- Filtrar por columnas --}}
    <script src="{{ URL::to('js/export.js') }}"></script>
  @endpush