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
          <i class="fa-solid fa-list-ol mr-2"></i>
          <a href="{{ route('users.filters') }}">Cancelar</a>
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
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('scripts')
  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

  {{-- Avatar --}}
  <script type="text/javascript">
    let newimage = [];
    Dropzone.autoDiscover = false;

    let myDropzone = new Dropzone("#dropzone", {
      url: '{{ route('dropzone.store') }}',
      // type='post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      parallelUploads: 1,
      uploadMultiple: true,
      // acceptedFiles: '.png,.jpg,.jpeg',
      acceptedFiles: 'image/*',
      addRemoveLinks: true,
      paramName: 'image',     // Cambiar 'file' por 'image'
	    maxFiles: 1,
      dictDefaultMessage: "<h3 class='sbold'>Suelte los archivos aquí o haga clic para cargar el(los) documento(s)<h3>",
      dictRemoveFile:'Quitar',

      removedfile: function(file) {
        var removeimageName = $(file.previewElement).find('.dz-filename span').data('dz-name');
        $.ajax({
          type: 'POST',
          url: '{{ route('remove.file') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            removeimageName: removeimageName
          },
          success: function(data) {
            console.log(data);
            for (var i = 0; i < newimage.length; i++) {
              if (newimage[i] === data) {
                newimage.splice(i, 1);
              }
            }
            $(".newimage").val(newimage);
          }
        });
        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
      },
      success: function(file, response) {
        console.log(file);
        newimage.push(response);
        console.log(newimage);
        $(".newimage").val(newimage);
        $(file.previewTemplate).find('.dz-filename span').data('dz-name', response);
        $(file.previewTemplate).find('.dz-filename span').html(response);
      }
    });
  </script>
@endpush