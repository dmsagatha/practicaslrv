@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
    <div class="flow-root w-full mx-auto shadow m-10 py-4 bg-white rounded sm:px-1 sm:py-2">
      <form  action="{{route('users.search')}}" method ="POST">
        @csrf

        <div class="relative form-group mt-6">
          <label for="names" class='absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm'>
            Nombres
          </label>
          <input type="text" class="f-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black" id="names" name="names" required/>
        </div>

        <div class="py-4">
        <button type='submit' class='inline-flex items-center justify-center px-2 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition' name="search">
          <i class="fa-solid fa-save mr-2"></i>Filtrar
        </button></div>
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
    <script>
      $(document).ready(function () {
        $('#dtFilters').DataTable({
          lengthMenu: [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Todos"]],
          processing: true,
          language: {
            url: "{{ asset('plugins/dataTables/Spanish.json') }}"
          },
          scrollX: false,
        });
      });
    </script>
  @endpush