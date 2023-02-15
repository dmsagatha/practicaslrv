@extends('layouts.app')

<?php
  if ($user->exists):
    $form_data = ['route' => ['users.update', $user], 'method' => 'PUT', 'files' => 'true'];
    $action    = ' Actualizar';
  else:
    $form_data = ['route' => ['users.store'], 'method' => 'POST', 'files' => 'true'];
    $action    = ' Crear';
  endif;
?>

@section('title', 'Crea Usuario')

@section('content')
  <div class="flow-root w-full mx-auto shadow bg-white rounded mt-24 py-6 px-4">
    {{ Form::model($user, $form_data) }}

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
    {{ Form::close() }}
  </div>
@endsection

@push('styles')
  {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
@endpush

@push('scripts')
  {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}

  {{-- Avatar --}}
@endpush