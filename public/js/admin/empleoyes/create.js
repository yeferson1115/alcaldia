$(document).ready(function(){


  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');
        
        

        if ($('#main-form #area_id').val() === '') {
            $('#main-form #area_id_alert').text('Campo Obligatorio').show();
            $('#main-form #area_id').focus();
            return false;
        }
        if ($('#main-form #role_id').val() === '') {
            $('#main-form #role_id_alert').text('Campo Obligatorio').show();
            $('#main-form #role_id').focus();
            return false;
        }

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Ingrese el Nombre').show();
            $('#main-form #name').focus();
            return false;
        }
        if ($('#main-form #last_name').val() === '') {
            $('#main-form #last_name_alert').text('Ingrese el apellido').show();
            $('#main-form #last_name').focus();
            return false;
        }
        if ($('#main-form #type_document').val() === '') {
            $('#main-form #type_document_alert').text('Selecciones el tipo de documento').show();
            $('#main-form #type_document').focus();
            return false;
        }

        if ($('#main-form #document').val() === '') {
            $('#main-form #document_alert').text('Ingrese el número de documento').show();
            $('#main-form #document').focus();
            return false;
        }

        if ($('#main-form #city').val() === '') {
            $('#main-form #city_alert').text('Seleccione una ciudad').show();
            $('#main-form #city').focus();
            return false;
        }

        if ($('input[name=sex]:checked').val() == undefined) {
          $('#main-form #sex_alert').text('Seleccione el genero del estudiante').show();
          $('#main-form #sex').focus();
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
       
       
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'POST',
    	        data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                if (response.status === 'success') {
                  // Mostrar mensaje de éxito                 
                  _alertGeneric('success','Success',response.message,'/empleados');
                  
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
       

       return false;

    });
});
