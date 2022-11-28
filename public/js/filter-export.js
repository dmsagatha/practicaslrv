/* Filtrar por columnas <thead></thead>
http://live.datatables.net/ruyezofa/1/edit
https://www.datatables.net/examples/api/multi_filter_select.html
http://live.datatables.net/cusologu/7/edit
Filtrar por columnas <tr></tr>
http://live.datatables.net/tamixov/1/edit */
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

    // Filtros: Adicionar un tr después del thead
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

    // Filtros en el tfoot
    initComplete: function () {
      this.api().columns('.head' ).every( function () {
        var column = this;
        var select = $('<select><option value="">Seleccionar</option></select>')
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


/* $('#example').DataTable( {
// "dom" : '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',

  initComplete: function () {
      this.api().columns().every(function () {
          var column = this;
          $(column.header()).append("<br>")
          var select = $('<select><option value="">Seleccionar</option></select>')
            .appendTo($(column.header()))
                      .on('change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );

                          column
                              .search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });
                  column.data().unique().sort().each(function (d, j) {
                      select.append('<option value="' + d + '">' + d + '</option>')
            } );
      } );
  }
} ); */