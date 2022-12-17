<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Practicas Laravel - @yield('title')</title>
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.dataTables.min.css">

    <style>
      /*Overrides for Tailwind CSS */
  
      /*Form fields*/
      .dataTables_wrapper select,
      .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        /*text-gray-700*/
        padding-left: 1rem;
        /*pl-4*/
        padding-right: 1rem;
        /*pl-4*/
        padding-top: .5rem;
        /*pl-2*/
        padding-bottom: .5rem;
        /*pl-2*/
        line-height: 1.25;
        /*leading-tight*/
        border-width: 2px;
        /*border-2*/
        border-radius: .25rem;
        border-color: #edf2f7;
        /*border-gray-200*/
        background-color: #edf2f7;
        /*bg-gray-200*/
      }
  
      /*Row Hover*/
      table.dataTable.hover tbody tr:hover,
      table.dataTable.display tbody tr:hover {
        background-color: #ebf4ff;
        /*bg-indigo-100*/
      }
  
      /*Pagination Buttons*/
      .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        border: 1px solid transparent;
        /*border border-transparent*/
      }
  
      /*Pagination Buttons - Current selected */
      .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        /*text-white*/
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        /*shadow*/
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        background: #667eea !important;
        /*bg-indigo-500*/
        border: 1px solid transparent;
        /*border border-transparent*/
      }
  
      /*Pagination Buttons - Hover */
      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        /*text-white*/
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        /*shadow*/
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        background: #667eea !important;
        /*bg-indigo-500*/
        border: 1px solid transparent;
        /*border border-transparent*/
      }
  
      /*Add padding to bottom border */
      table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        /*border-b-1 border-gray-300*/
        margin-top: 0.75em;
        margin-bottom: 0.75em;
      }
  
      /*Change colour of responsive icon*/
      table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
      table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
        /*bg-indigo-500*/
      }
    </style>

    @stack('styles')

    <script src="{{ mix('js/app.js') }}" defer></script>

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
                  <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="{{ route('users.index') }}">Filtrar | TFoot</a></li>
                  <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="{{ route('users.filters') }}">Filtrar | Select tag</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </nav>
      </div>
      
      <div class="container-fluid ">
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

    {{-- Cómo eliminar múltiples registros usando checkbox
    https://dev.to/codeanddeploy/how-to-delete-multiple-records-using-checkbox-in-laravel-8-4c0n --}}
    <script type="text/javascript">
      $(document).ready(function() {
        $(".delete-table").TableCheckAll();

        $('#multi-delete').on('click', function() {
          var button = $(this);
          var selected = [];

          $('.delete-table .check:checked').each(function() {
            selected.push($(this).val());
          });

          if (selected.length <= 0) {
            // Swal.fire('Debe seleccionar al menos una fila.');
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Debe seleccionar al menos una fila!',
              timer: 2000,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Esta seguro?',
              text: "Este registro se eliminará definitivamente!",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, eliminar!',
              cancelButtonText: 'No, cancelar!',
              reverseButtons: true,
              showDenyButton: false
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  type: 'post',
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: button.data('route'),
                  data: {
                    'selected': selected
                  },
                  success: function (response, textStatus, xhr) {
                    Swal.fire({
                      icon: 'success',
                      title: response,
                      showDenyButton: false,
                      showCancelButton: false,
                      // confirmButtonText: 'Si',
                      timer: 2000,
                      showConfirmButton: false
                    }).then((result) => {
                      // window.setTimeout("location.reload()", 1000); // window.location='/usuarios'
                      location.reload();
                    });
                  }, // success
                  /* success: function (response, textStatus, xhr) {
                    Swal.fire(
                      'Eliminado!',
                      'El registro fue eliminado.',
                      'success'
                    ).then((result) => {
                      window.setTimeout("location.reload()", 500); // window.location='/usuarios'
                    });
                  }, */
                }); // $.ajax()
              } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                  icon: 'error',
                  title: 'Cancelado.',
                  text: 'Los registros no fueron eliminados.!',
                  timer: 2000,
                  showConfirmButton: false
                });
              }
            });
          };
        });

        $('.delete-form').on('submit', function(e) {
          e.preventDefault();
          var button = $(this);

          Swal.fire({
            icon: 'warning',
            title: '¿Está seguro de eliminar este registro?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Si'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: button.data('route'),
                data: {
                  '_method': 'delete'
                },
                success: function (response, textStatus, xhr) {
                  Swal.fire({
                    icon: 'success',
                    title: response,
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'Si'
                  }).then((result) => {
                    window.setTimeout("location.reload()", 1000);
                  });
                }
              });
            }
          });

        })
      });
    </script>

    @stack('scripts')
  </body>
</html>