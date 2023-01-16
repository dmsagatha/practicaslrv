@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
    <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
      <div class="flex justify-between py-2">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Total Usuarios <span class="px-1 rounded-md bg-blue-500 text-white">{{ count($users) }}</span>
        </h2>
        
        <!-- Dropdown toggle -->
        <div x-data="{ isOpen: false }" class="relative inline-block">
          <!-- Dropdown toggle button -->
          <button @click="isOpen = !isOpen" class="relative z-10 block p-2 text-gray-700 bg-white border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
            </svg>
          </button>
      
          <!-- Dropdown menu -->
          <div x-show="isOpen" 
            @click.away="isOpen = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" 
            class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800"
          >
            <a href="{{ route('users.index') }}" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">
              <i class="fas fa-list mr-1"></i>Filtrar | TFoot 
            </a>
            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">Ayuda</a>
            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">Configuración</a>
            <a href="#" class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">Salir</a>
          </div>
        </div>
      </div>

      @if ($message = Session::get('success'))
        <div class="bg-green-100 mb-4 px-5 py-4 w-full border-l-4 border-green-500">
          <div class="flex justify-between">
            <div class="flex space-x-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="flex-none fill-current text-green-500 h-4 w-4">
                <path
                  d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 16.518l-4.5-4.319 1.396-1.435 3.078 2.937 6.105-6.218 1.421 1.409-7.5 7.626z"/>
              </svg>
              <div class="flex-1 leading-tight text-sm text-green-700 font-medium">{{ $message }}</div>
            </div>
          </div>
        </div>
      @endif

      {{-- @if (isset($errors) && $errors->any())
        @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
      @endif --}}

      @include('partials.failures')
      
      <div class="grid grid-cols-6 gap-x-10 gap-y-8 px-10">
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

        <!-- Importar -->
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <div class="bg-gray-50 py-2 px-3 rounded shadow-xl text-gray-800">
              <div class="flex justify-between items-center">
                <h4 class="text-md font-bold">Subir archivo (Con encabezados) (Xlsx, Xls)</h4>
              </div>
              <div>
                <form action="{{ route('users.uploadData') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="py-2 text-sm">
                    <label class="block mb-6">
                      <input type="file" name="upload_file" class="block w-full mt-1 border focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-sm" />
                    </label>
                    {!! $errors->first("upload_file", '<small class="text-sm text-red-600">:message</small>') !!}
                  </div>

                  <div class="flex justify-end space-x-6">
                    <button type="submit" class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                      <a href="{{ route('users.filters') }}">Cancelar</a>
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center px-2 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">Subir datos
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <h3>Importer</h3>

        <p>Sélectionnez un fichier Excel (.xlsx) pour importer les données dans la table "clients".<br><strong>Les colonnes : </strong>name, email, phone, address</p>

        <form method="POST" action="{{ route('users.simpleExcel') }}" enctype="multipart/form-data" >

            <!-- CSRF Token -->
            @csrf

            <input type="file" name="fichier" >

            <button type="submit" >Importer</button>

        </form>
        
        <!-- Eliminación masiva -->
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative mt-4">
            <button type="submit" id="delete_records" class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring-4 focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-route="{{ route('users.multipleDelete') }}" style="display:none;">
              <i class="fa-solid fa-trash-alt mr-1"></i>Eliminar seleccionados (<span class="rows_selected" id="select_count"></span>)
            </button>
          </div>
        </div>
      </div>

      <div class="px-4 py-4 pb-10">
        @if ($users->count())
          @include('admin.users._table-filters')
        @else
          <div class="flex justify-center px-4 mt-14 mb-2 space-x-4 text-blue-600">
            No hay registros creados
          </div>
        @endif
      </div>
    </div>
  @endsection

  {{-- Banco de Occidente - Tuplus - estefani gonzalez 20/12/2022 --}}

  @push('scripts')
    {{-- Filtrar por columnas --}}
    <script src="{{ URL::to('js/export.js') }}"></script>
  @endpush