<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Practicas Laravel - @yield('title')</title>
    
    {{-- <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"> --}}
    <link rel="icon" href="{{ url('/favicon.ico') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('css/styleApp.css') }}">

    @stack('styles')

    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  </head>
  <body class="h-screen bg-gray-100 font-sans antialiased leading-normal tracking-normal">
    <div class="w-full text-gray-900">
      <div class="flex flex-col">
        <nav class="flex justify-around py-2 bg-white/80 backdrop-blur-md shadow-md w-full fixed top-0 left-0 right-0 z-10">
          <div class="w-full flex items-center justify-between mt-0 px-6 py-2">
            <div class="md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
              <nav>
                <ul class="md:flex items-center justify-between text-base text-blue-600 pt-4 md:pt-0">
                  <li>
                    <a class="inline-block no-underline hover:text-black font-semibold text-lg py-2 px-4 lg:-ml-2" href="{{ route('users.filters') }}">
                      Filtrar | Select tag
                    </a>
                  </li>
                  <li>
                    <a class="inline-block no-underline hover:text-black font-semibold text-lg py-2 px-4 lg:-ml-2" href="{{ route('users.index') }}">
                      Filtrar | TFoot
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </nav>
      </div>
      
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
          pageLength: 25,
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
          order: [[1, 'asc']]
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

    <script>
      // Eliminar un registro
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