$(document).ready(function(){

  $('#main-form').submit(function(){
      $('.missing_alert').css('display', 'none');

      if ($('input[name="empleoye_id[]"]:checked').length === 0) {
        _alertGeneric('info','Informacion','Seleccione almenos un empleado',null);
        return false;
      }

      var data = $('#main-form').serialize();
      $('#preloader').fadeIn(); // ← Mostrar preloader

      $.ajax({
        url: $('#main-form #_url').val(),
        headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
        type: 'POST',
        cache: false,
        data: data,
        success: function (response) {
          $('#preloader').fadeOut(); // ← Ocultar preloader
          if (response.status === 'success') {
            _alertGeneric('success','Success',response.message,'/carnets-empleados');
          } else {
            _alertGeneric('info','Error',response.message,null);
          }
        },
        error: function(xhr, status, error) {
          $('#preloader').fadeOut(); // ← Ocultar preloader
          if (xhr.status === 422) {
              var errors = xhr.responseJSON.errors;
              var errorMessages = '';
              $.each(errors, function(key, value) {
                  errorMessages  = value[0]+'\n';
              });
              _alertGeneric('question','Error','Errores de validación:\n'+errorMessages,null);
          } else {
              _alertGeneric('error','Error','Error: ' +xhr.responseJSON.message,null);
          }
        }
      });

      return false;
  });
});
