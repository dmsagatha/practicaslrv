/* 
  Eliminar múltiples registros usando checkbox
  https://dev.to/codeanddeploy/how-to-delete-multiple-records-using-checkbox-in-laravel-8-4c0n 
 */
$(document).ready(function() {
  $(".delete_table").TableCheckAll();

  $('#multiple_delete').on('click', function() {
    let button   = $(this);
    let selected = []

    $('.delete_table .check:checked').each(function() {
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
                // window.setTimeout("location.reload()", 1000); // window.location='/usuarios'
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