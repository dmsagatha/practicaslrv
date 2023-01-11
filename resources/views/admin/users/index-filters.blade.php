@extends('layouts.app')
  @section('title', 'Usuarios')

  @section('content')
    <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
      <div class="flex justify-between py-2">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Total Usuarios <span class="px-1 rounded-md bg-blue-500 text-white">{{ count($users) }}</span>
        </h2>

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
      
      @if(Session::get('success', false))
        <?php $data = Session::get('success'); ?>
        @if (is_array($data))
          @foreach ($data as $msg)
            <div class="alert alert-success" role="alert">
              <i class="fa fa-check"></i>{{ $msg }}
            </div>
          @endforeach
        @else
          <div class="alert alert-success" role="alert">
            <i class="fa fa-check"></i>{{ $data }}
          </div>
        @endif
      @endif
      
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

        <div class="col-span-6 sm:col-span-3">
          <div class="group relative">
            <div class="bg-gray-50 py-2 px-3 rounded shadow-xl text-gray-800">
              <div class="flex justify-between items-center">
                <h4 class="text-md font-bold">Subir archivo (Xlsx, Xls)</h4>
              </div>
              <div>
                <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="file" id="upload_file" name="upload_file"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md" multiple data-max-file-size="3MB" data-max-files="3" />
                  
                  {{-- <input type="file" class="filepond" name="filepond" multiple data-max-file-size="3MB" data-max-files="3" /> --}}

                  {{-- <div class="max-w-xl">
                    <label
                        class="flex justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                        <span class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="font-medium text-gray-600">
                                Drop files to Attach, or
                                <span class="text-blue-600 underline">browse</span>
                            </span>
                        </span>
                        <input type="file" name="file_upload" class="hidden">
                    </label>
                  </div>
                  
                  <div class="py-2 text-sm">
                    <label class="block mb-6">
                      <input type="file" name="photo" class="block w-full mt-1 border focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-sm" />
                    </label>
                  </div> --}}

                  <div class="flex justify-end space-x-6">
                    {{-- <button type="submit" class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm
                     text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"><a href="{{ route('users.filters') }}">Cancelar</a>
                    </button> --}}
                    <button type="submit" class="inline-flex items-center justify-center px-2 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">Subir datos
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-span-6 sm:col-span-3">
          <div class="group relative mt-4">
            <button type="submit" id="delete_records" class="inline-flex items-center justify-center px-2 py-2 bg-red-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring-4 focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-route="{{ route('users.multipleDelete') }}" style="display:none;">
              <i class="fa-solid fa-trash-alt mr-1"></i>Eliminar seleccionados (<span class="rows_selected" id="select_count"></span>)
            </button>
          </div>
        </div>
      </div>

      <div class="px-4 py-4">
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