$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');
        
        

        if ($('#main-form #file').val() === '') {
            $('#main-form #file_alert').text('Ingrese un archivo').show();
            $('#main-form #file').focus();
            return false;
        }





        $('.loading').show();
        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
        var formData = new FormData($("#main-form")[0]);
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
        Pace.track(function () {
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'POST',
    	        data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                $('.loading').css('display','none');
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form #submit').hide();
                  $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Estudiantes autorizados al PAE correctamente',1);
                  //toastr.success('Cliente guartado correctamente');
                  //$(location).attr('href', '/institutions');
                }
              },error: function (data) {
                $('.loading').css('display','none');
                _alertGeneric('error','Error! ','Ocurrio un error en la autorizacón, intentalo nuevamente',1);
                $('input').iCheck('enable');
                $('#main-form input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        });

       return false;

    });
});
