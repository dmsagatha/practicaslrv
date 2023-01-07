/* 
  Eliminación masiva de datos y contador de seleccionados
  https://www.phpzag.com/delete-multiple-rows-with-checkbox-using-jquery-php-mysql/
  https://github.com/mbere250/Laravel-8-Ajax-CRUD-with-Yajra-Datatable
 */
/* 
  #bulk_delete -> seleccionar todas las casillas de verificación
  .check_item  -> seleccionar por item  
*/
$(function () {
  $('#bulk_delete').on('click', function() {
    if($(this).is(':checked',true)) {
      $(".check_item").prop('checked', true);
    } else {
      $(".check_item").prop('checked',false);
    }
    toggleDeleteAllBtn();
  });

  $(document).on('click', '.check_item', function() {
    if ($('.check_item').length == $('.check_item:checked').length) {
      $('#bulk_delete').prop('checked', true);
    } else {
      $('#bulk_delete').prop('checked', false);
    }
    toggleDeleteAllBtn();
  });

  // Eliminar los registros seleccionados
  $('#delete_records').on('click', function(e) {
    e.preventDefault();
    let allVals = [];

    $(".check_item:checked").each(function() {
      allVals.push($(this).attr('data-id'));
    });

    if(allVals.length <= 0) {
      Swal.fire({
        icon: 'error',
        text: 'Debe seleccionar al menos una fila!',
        timer: 2000,
        showConfirmButton: false,
        showConfirmButton: false
      });
    } else {
      let join_selected_values = allVals.join(",");

      Swal.fire({
        icon: 'warning',
        title: 'Esta seguro?',
        // text: "Este registro se eliminará definitivamente!",
        text: "Es seguro eliminar "+(allVals.length>1 ? "estas filas?" : "esta fila?"),
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true,
        showDenyButton: false
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: $(this).data('route'),    // data-route
            // url: $(this).attr('action'),
            // url: $(this).attr("href"),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: 'ids='+join_selected_values,
            data: {ids: join_selected_values},
            success: function (data) {
              if (data['success']) {
                $(".check_item:checked").each(function() {
                  $(this).parents("tr").remove();
                });
                Swal.fire({
                  icon: 'success',
                  title: 'Registros eliminados satisfactoriamente.',
                  showDenyButton: false,
                  showCancelButton: false,
                  timer: 2000,
                  showConfirmButton: false
                }, data).then((result) => {
                  location.reload();
                });
              } else if (data['error']) {
                Swal.fire(
                  'Cancelado',
                  'Los registros no fueron eliminados!',
                  'error',
                  data
                )
              } else {
                Swal.fire('Vaya algo salió mal.', 'warning');
              }
            },
            error: function (data) {
              alert(data.responseText);
            }
          }); // $.ajax()
          $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
          });
        } else if(result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            icon: 'error',
            title: 'Cancelado.',
            text: 'Los registros no fueron eliminados.!',
            timer: 3000,
            showConfirmButton: false
          });
          location.reload();
        }
      });
    }  // if(allVals.length <= 0)
  });
});

function toggleDeleteAllBtn() {
  if( $('.check_item:checked').length > 0 ) {
    // $('button#delete_records').text('Eliminar seleccionados ('+$('.check_item:checked').length+')').show();
    $('button#delete_records').show();
    $("#select_count").html($("input.check_item:checked").length+"").show();
  } else {
    $('button#delete_records').hide();
  }
};

/* 
  Eliminar múltiples registros usando checkbox
  https://dev.to/codeanddeploy/how-to-delete-multiple-records-using-checkbox-in-laravel-8-4c0n 
 */
/* $(document).ready(function() {
  $(".delete_table").TableCheckAll();

  $('#multiple_delete').on('click', function() {
    let button   = $(this);
    let selected = []

    $('.delete_table .check:checked').each(function() {
      selected.push($(this).val());
    });

    if (selected.length <= 0) {
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
            success: function(response, textStatus, xhr) {
              Swal.fire({
                icon: 'success',
                title: response,
                showDenyButton: false,
                showCancelButton: false,
                // confirmButtonText: 'Si',
                timer: 2000,
                showConfirmButton: false
              }).then((result) => {
                location.reload();
              });
            },
            error: function(response, textStatus, xhr) {
              alert(data.responseText);
            }
          }); // $.ajax()
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            icon: 'error',
            title: 'Cancelado.',
            text: 'Los registros no fueron eliminados.!',
            timer: 2000,
            showConfirmButton: false
          });
          location.reload();
        }
      });
    };
  });
}); */