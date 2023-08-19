<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Practicas Laravel - @yield('title')</title>
    
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('css/styleApp.css') }}">

    @stack('styles')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  </head>
  <body class="h-screen font-sans antialiased leading-normal tracking-normal">
    <div class="w-full">
      <nav class="border-b bg-slate-300">
        <div class="container max-w-screen-lg mx-auto flex justify-between h-14">
          <!-- Brand-->
          <a href="#" class="flex items-center cursor-pointer hover:bg-purple-50 px-2 ml-3">
            <!-- Logo-->
            <div class="flex justify-center w-10 h-10 rounded bg-purple-400 text-white font-bold  text-3xl pt-0.5">L</div>
            <div class="text-gray-700 font-semibold ml-2">Laravel 10</div>
          </a>
          <!-- Navbar Toggle Button -->
          <button type="button" class="text-gray-700 p-2 rounded hover:border focus:bg-slate-100 my-2 mr-5" aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="w-5 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
          </button>
          <!-- Nav Links-->
          <ul class="flex text-gray-700 text-base" id="navbar-main">
            <li class="flex items-center px-3 cursor-pointer hover:bg-purple-50 hover:text-gray-800">
              <a href="#">Laravel</a>
            </li>
            <li class="flex items-center px-3 cursor-pointer hover:bg-purple-50 hover:text-gray-800">
              <a href="#">Livewire</a>
            </li>
            <li class="flex items-center px-3 cursor-pointer hover:bg-purple-50 hover:text-gray-800">
              <a href="#">TailwindCSS</a>
            </li>
            <li class="flex items-center px-3 cursor-pointer hover:bg-purple-50 hover:text-gray-800">
              <a href="#">Alpine JS</a>
            </li>
            <li class="flex items-center px-3 cursor-pointer hover:bg-purple-50 hover:text-gray-800">
              <a href="#">About</a>
            </li>
          </ul>
        </div>
      </nav>
      
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('plugins/dataTables/TableCheckAll.js') }}"></script>
    <script src="{{ asset('js/filter-export.js') }}"></script>
    <script src="{{ asset('js/deleteBuilk.js') }}"></script>

    {{-- 
      Filtrar con la etiqueta select
      http://live.datatables.net/vepedopa/10/edit
      Reset Selected columnas - https://jsfiddle.net/2k07k5ba/2/ 
    --}}
    <script>
      $(document).ready(function() {
        var DT1 = $('#exampleFilters').DataTable({
          responsive: true,
          lengthMenu: [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Todos"]],
          pageLength: 10,
          processing: true,
          language: {
            url: "{{ asset('plugins/dataTables/Spanish.json') }}"
          },
          colReorder: true,

          dom: 'Blfrtip',
          buttons: [
            {
              extend: 'excel',
              split: ['pdf', 'csv'],
            },
            { 
              text: 'Restablecer filtros',
              action: function () {
                DT1.search('').columns().search('').draw();
              }
            }
          ],

          columnDefs: [ 
            {
              orderable: false,
              className: 'select-checkbox',
              targets:   0,
            } 
          ],

          select: {
            style:    'os',
            selector: 'td:first-child'
          },
          // order: [[2, 'asc']]
        });

        /* $('#reset').click( function (e) {
          e.preventDefault();
          
          DT1.colReorder.reset();
        }); */

        $(".selectAll").on( "click", function(e) {
          if ($(this).is( ":checked" )) {
              DT1.rows(  ).select();        
          } else {
              DT1.rows(  ).deselect(); 
          }
        });
      
        $('#search').on('input', () => {
          DT1.search($('#search').val()).draw();
        });

        $('#field1').on('change', () => {            
          DT1.search($("#field1").val()).draw();
        });

        $('#field2').on('change', () => {            
          DT1.search($("#field2").val()).draw();
        });
      });
    </script>

    {{-- Delete a record --}}
    <script>
      window.deleteConfirm = function(formId) {
        Swal.fire({
          icon: 'warning',
          title: 'Esta seguro?',
          text: "Este registro se eliminará definitivamente!",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!',
          cancelButtonText: 'No, cancelar!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Eliminado!',
              'El registro fue eliminado.',
              'success'
            )
            document.getElementById(formId).submit();
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              icon: 'error',
              title: 'Cancelado.',
              text: 'El registro no fue eliminado.!',
              timer: 2000,
              showConfirmButton: false
            });
          }
        })
      }
    </script>

    @stack('scripts')
  </body>
</html>