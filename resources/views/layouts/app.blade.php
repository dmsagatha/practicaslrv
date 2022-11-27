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
                  <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="{{ route('users.index') }}">Usuarios | Filtrar</a></li>
                  <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="#">Menú 2</a></li>
                  <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" href="#">Menú 3</a></li>
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

    {{-- Filtrar por columnas <thead></thead> --}}
    {{-- http://live.datatables.net/ruyezofa/1/edit
    https://www.datatables.net/examples/api/multi_filter_select.html
    http://live.datatables.net/cusologu/7/edit
    Filtrar por columnas <tr></tr>
    http://live.datatables.net/tamixov/1/edit --}}
    <script>
      $(document).ready(function(){
        $('#example').DataTable({
          responsive: true,
          lengthMenu: [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "Todos"]],
          pageLength: 10,
          processing: true,
          language: {
            url: "{{ asset('plugins/dataTables/Spanish.json') }}"
          },
          scrollX: false,
          fixedHeader: true,
          orderCellsTop: true,

          columnDefs: [
            {
              targets: 0,
              render: function (data, type, row) {
                if ( type === 'filter' ) {
                  // Strip HTML from the cell data and return only the text
                  return data.replace(/<[^>]*>?/gm, '');
                }
                return data;
              }
            }
          ],

          dom: 'Blfrtip',
          buttons: [
            {
              extend: 'excel',
              split: ['pdf', 'csv'],
            }
          ],

          // Filtrar por columnas <tfoot></tfoot>
          /* initComplete: function() {
            this.api().columns('.head').every(function () {
              var column = this;
              var select = $('<select><option value=""></option></select>')
                .appendTo($("#example thead tr:eq(1) th").eq(column.index()).empty())
                  var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                  );
                  column
                    .search(val ? '^'+val+'$' : '', true, false)
                    .draw();
                });

              column.data().unique().sort().each(function (d, j) {
                select.append('<option value="'+d+'">'+d+'</option>');
              });
            });
          }, */

          initComplete: function () {
            this.api().columns('.head' ).every( function () {
              var column = this;
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                  );

                  column
                    .search( val ? '^'+val+'$' : '', true, false )
                    .draw();
                });
              column.data().unique().sort().each( function (d, j) {
                select.append('<option value="'+d.replace(/<[^>]*>?/gm, '')+'">'+d+'</option>')
              });
            });
          }
          
          /* dom: '<"html5buttons"B>lTfgitp',
          buttons: [
            {extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},
            {extend: 'print',
              customize: function (win) {
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                  .addClass('compact')
                  .css('font-size', 'inherit');
              }
            }
          ] */
        })
				.columns.adjust()
				.responsive.recalc();
      });
    </script>

    @stack('scripts')
  </body>
</html>