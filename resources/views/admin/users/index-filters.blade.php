@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
    <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
      @if(Session::get('success', false))
        <?php $data = Session::get('success'); ?>
        @if (is_array($data))
            @foreach ($data as $msg)
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check"></i>
                    {{ $msg }}
                </div>
            @endforeach
        @else
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $data }}
            </div>
        @endif
      @endif
      
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
        
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <button type='submit' class='inline-flex items-center justify-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition' id="multiple_delete" data-route="{{ route('users.multipleDelete') }}">
              <i class="fa-solid fa-trash mr-2"></i>Eliminar seleccionados
            </button>
          </div>
        </div>
        
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <button type="submit" id="delete_records" class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring-4 focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-route="{{ route('users.multipleDelete') }}">
              <i class="fa-solid fa-trash-alt mr-1"></i>Eliminar seleccionados (<span class="rows_selected" id="select_count"></span>)
            </button>
          </div>
        </div>
      </div>

      <div class="flex flex-col">
        <div class="w-full">
          <div class="border-b border-gray-300 shadow">
            <table id="exampleFilters" class="table table-condensed stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
              <thead>
                <tr>
                  <th><input type="checkbox" id="check_all"></th>
                  <th>ID</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Correo Electrónico</th>
                  <th>Fecha</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $item)
                  <tr id="tr_{{ $item->id }}">
                    <td>
                      <input type="checkbox" class="check_item" data-id="{{ $item->id }}">
                    </td>
                    <td class="text-center">{{ $item->id }}</td>
                    <td>{{ $item->first_name}}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-xs text-center">
                      {{ date("Y/m/d", strtotime($item->created_at))}}
                    </td>
                    <td>
                        {{-- <form method="post" class="delete-form" data-route="{{route('posts.destroy',$post->id)}}">
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form> --}}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- <div class="px-4 py-4">
        @if ($users->count())
          @include('admin.users._table-filters')
        @else
          <div class="flex justify-center px-4 mt-14 mb-2 space-x-4 text-blue-600">
            No hay registros creados
          </div>
        @endif
      </div> --}}
    </div>
  @endsection

  @push('scripts')
    {{-- Filtrar por columnas --}}
    <script src="{{ URL::to('js/export.js') }}"></script>
  @endpush