@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
  <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
      <form  action="{{route('users.search')}}" method ="POST">
        @csrf

        <div class="grid grid-cols-6 gap-x-10 gap-y-8">
          <div class="col-span-6 sm:col-span-3">
            <div class="group relative">
              <label for="names" class='form-label inline-block font-medium text-md text-gray-700'>
                Nombres
              </label>
              <input type="text" class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 px-3 ring-1 ring-slate-400 shadow-sm" id="names" name="names">
            </div>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <div class="group relative">
              <label for="surnames" class='form-label inline-block font-medium text-md text-gray-700'>
                Apellidos
              </label>
              <input type="text" class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 px-3 ring-1 ring-slate-400 shadow-sm" id="surnames" name="surnames">
            </div>
          </div>

          <div class="col-span-6 sm:col-span-3">
            <div class="group relative">
              <label for="other" class='form-label inline-block font-medium text-md text-gray-700'>
                Otro
              </label>
              <input type="text" class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 px-3 ring-1 ring-slate-400 shadow-sm" id="other" name="other">
            </div>
          </div>

          <div class="pt-6">
            <button type='submit' class='inline-flex items-center justify-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition' name="search">
              <i class="fa-solid fa-magnifying-glass mr-2"></i>Filtrar
            </button>
          </div>
        </div>
      </form>

      <div class="px-4 py-4">
        @if ($users->count())
          @include('admin.users._table')
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