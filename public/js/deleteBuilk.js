/* 
  Eliminación masiva de datos y contador de seleccionados
  https://www.phpzag.com/delete-multiple-rows-with-checkbox-using-jquery-php-mysql/
  https://github.com/mbere250/Laravel-8-Ajax-CRUD-with-Yajra-Datatable
 */
/* 
  #bulk_delete -> seleccionar todas las casillas de verificación
  .check_item  -> seleccionar por item  
*/
$(document).on('click', '#bulk_delete', function() {
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
  let ids_records = [];

  $('.check_item:checked').each(function() {  
    ids_records.push($(this).data('id'));
  });
    
  if(ids_records.length <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Debe seleccionar al menos una fila!',
      timer: 2000,
      showConfirmButton: false
    });
  } else {
    let selected_values = ids_records.join(",");

    Swal.fire({
      icon: 'warning',
      title: 'Esta seguro?',
      // text: "Este registro se eliminará definitivamente!",
      text: "Esta seguro de eliminar "+(ids_records.length>1?"estas filas?":"esta fila?"),
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
          url: $(this).data('route'),
          // url: button.data('route'),
          // url: "{{ route('users.multipleDelete') }}",
          // data: 'ids='+selected_values,
          data: {ids: selected_values},
          success: function(response, textStatus, xhr) {
            Swal.fire({
              icon: 'success',
              // title: 'Registros eliminados satisfactoriamente.',
              title: response,
              showDenyButton: false,
              showCancelButton: false,
              timer: 2000,
              showConfirmButton: false
            }).then((result) => {
              location.reload();
            });
          },
          error: function(response, textStatus, xhr) {
            alert(data.responseText);
          }
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
  }
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
}); */