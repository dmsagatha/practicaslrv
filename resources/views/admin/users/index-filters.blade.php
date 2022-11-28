@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
    <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
      <div class="grid grid-cols-6 gap-x-10 gap-y-8">
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <label class="block py-2 text-sm font-medium text-gray-900 dark:text-gray-400 requerid ">
              Nombres
            </label>
            <select id="field1" name="names" class='block w-full border-b-2 border-slate-300 bg-transparent text-gray-800 sm:text-xs placeholder-transparent focus:outline-none focus:ring-blue-500 focus:border-blue-500 py-2'>
              <option value="">Seleccionar</option>
              @foreach ($users as $item)
                <option value="{{ $item->id }}">{{ $item->first_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <label class="block py-2 text-sm font-medium text-gray-900 dark:text-gray-400 requerid ">
              Apellidos
            </label>
            <select id="field2" name="surnames" class='block w-full border-b-2 border-slate-300 bg-transparent text-gray-800 sm:text-xs placeholder-transparent focus:outline-none focus:ring-blue-500 focus:border-blue-500 py-2'>
              <option value="">Seleccionar</option>
              @foreach ($users as $item)
                <option value="{{ $item->id }}">{{ $item->last_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="px-4 py-4">
        @if ($users->count())
          @include('admin.users._table-filters')
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