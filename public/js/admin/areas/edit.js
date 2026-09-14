$(document).ready(function(){


 
  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Ingrese el nombre del Area').show();
            $('#main-form #name').focus();
            return false;
        }
        if ($('input[name=state]:checked').val() == undefined) {
            $('#main-form #state_alert').text('Seleccione un estado').show();
            $('#main-form #state').focus();
            return false;
        }
      

     





        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
        var formData = new FormData($("#main-form")[0]);
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-edit').addClass('fa fa-spin fa-refresh');
          $.ajax({
            url: $('#main-form #_url').val(),
            headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
            type: 'PUT',
            cache: false,
            data: data,
             success: function (response) {
              if (response.status === 'success') {
                // Mostrar mensaje de éxito                 
                _alertGeneric('success','Success',response.message,'/areas');
                
              }else {                  
                  _alertGeneric('info','Error',response.message,null);
              }
            },error: function(xhr, status, error) {
              if (xhr.status === 422) {
                  // Errores de validación
                  var errors = xhr.responseJSON.errors;
                  var errorMessages = '';
                  $.each(errors, function(key, value) {
                      errorMessages  = value[0]+'\n';
                  });
                  _alertGeneric('question','Error','Errores de validación:\n'+errorMessages,null);
              } else {
                  // Otros errores
                  _alertGeneric('error','Error','Error: ' +xhr.responseJSON.message,null);
              }
          }
         });
        });

       return false;

 
});
