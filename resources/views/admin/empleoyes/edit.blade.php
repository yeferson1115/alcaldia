@extends('layouts.app')

@section('title', 'Empleados')
@section('page_title', 'Crear Empleado')
@section('page_subtitle', 'Actualizar')
@section('content')

<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar Empleado</h2>
                
            </div>
        </div>
    </div>
    
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">                    
                    <div class="card-body">
                        <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form" autocomplete="off">
                            <!--<input type="hidden" id="_url" value="{{ url('institutions',[$empleoye->encode_id]) }}">-->
                            <input type="hidden" id="_url" value="{{ route('empleoyes.update', $empleoye->id) }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="area_id">Area</label>                                        
                                        <select class="invoiceto1 form-select customer" id="area_id" name="area_id" readonly>
                                            <option value="">Seleccione</option>                                            
                                            @foreach ($areas as $item)
                                                <option value="{{ $item->id }}" {{ $empleoye->area_id === $item->id ? "selected" : ""   }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="area_id_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="group">Cargo</label>                                        
                                        <select class="invoiceto1 form-select customer" id="role_id" name="role_id">
                                           <option value="">Seleccione</option>                                           
                                            @foreach ($charges as $item)
                                                <option value="{{ $item->id }}" {{ $empleoye->role_id === $item->id ? "selected" : ""   }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="role_id_alert"></span>
                                    </div>
                                </div>                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres" value="{{ $empleoye->name }}">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Apellidos</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos" value="{{ $empleoye->last_name }}">
                                        <span class="missing_alert text-danger" id="last_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type_document">Tipo de documento</label>
                                        <select class="invoiceto1 form-select customer" id="type_document" name="type_document">                                            
                                            
                                            <!--<option value="RC"  {{ $empleoye->type_document === "RC" ? "selected" : ""   }}>R.C</option>
                                            <option value="TI" {{ $empleoye->type_document === "TI" ? "selected" : ""   }}>T.I</option>-->
                                            <option value="CC" {{ $empleoye->type_document === "CC" ? "selected" : ""   }}>C.C</option> 
                                            <!--<option value="NES" {{ $empleoye->type_document === "NES" ? "selected" : ""   }}>NES</option>  
                                            <option value="PEP" {{ $empleoye->type_document === "PEP" ? "selected" : ""   }}>PEP</option>   
                                            <option value="DO-V" {{ $empleoye->type_document === "DO-V" ? "selected" : ""   }}>DO-V</option>-->
                                            <option value="PPT" {{ $empleoye->type_document === "PPT" ? "selected" : ""   }}>PPT</option>                                                  
                                            <!--<option value="CE" {{ $empleoye->type_document === "CE" ? "selected" : ""   }}>CE</option>  
                                            <option value="NIP" {{ $empleoye->type_document === "NIP" ? "selected" : ""   }}>NIP</option> 
                                            <option value="OD" {{ $empleoye->type_document === "OD" ? "selected" : ""   }}>OD</option> 
                                            <option value="NUIP" {{ $empleoye->type_document === "NUIP" ? "selected" : ""   }}>NUIP</option>-->
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="type_document_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="document">No. Documento</label>
                                        <input type="text" class="form-control" id="document" name="document" placeholder="No. Documento" value="{{ $empleoye->document }}">
                                        <span class="missing_alert text-danger" id="document_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Genero</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexm" value="M" {{ ($empleoye->sex=="M")? "checked" : "" }}>
                                                <label class="form-check-label" for="sexm">M</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexf" value="F" {{ ($empleoye->sex=="F")? "checked" : "" }}>
                                                <label class="form-check-label" for="sexf">F</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexOtro" value="Otro" {{ ($empleoye->sex=="Otro")? "checked" : "" }}>
                                                <label class="form-check-label" for="sexOtro">Otro</label>
                                            </div>
                                        </div>
                                        <span class="missing_alert text-danger" id="sex_alert"></span>
                                    </div>
                                </div>    
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone">Teléfono</label>
                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Télefono" value="{{ $empleoye->phone }}">
                                        <span class="missing_alert text-danger" id="phone_alert"></span>
                                    </div>
                                </div>   
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="rh">R.H</label>                                        
                                        <select class="invoiceto1 form-select customer" id="rh" name="rh">
                                            <option value="" ></option>
                                            <option value="A+"  {{ $empleoye->rh === "A+" ? "selected" : ""   }}>A+</option>
                                            <option value="O+" {{ $empleoye->rh === "O+" ? "selected" : ""   }}>O+</option>
                                            <option value="B+" {{ $empleoye->rh === "B+" ? "selected" : ""   }}>B+</option>
                                            <option value="AB+" {{ $empleoye->rh === "AB+" ? "selected" : ""   }}>AB+</option>
                                            <option value="A-" {{ $empleoye->rh === "A-" ? "selected" : ""   }}>A-</option>
                                            <option value="O-" {{ $empleoye->rh === "O-" ? "selected" : ""   }}>O-</option>
                                            <option value="B-" {{ $empleoye->rh === "B-" ? "selected" : ""   }}>B-</option>
                                            <option value="AB-" {{ $empleoye->rh === "AB-" ? "selected" : ""   }}>AB-</option>
                                            <option value="N/A" {{ $empleoye->rh === "N/A" ? "selected" : ""   }}>N/A</option>
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="rh_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city">Ciudad</label>
                                        <select class="invoiceto1 form-select customer" id="city" name="city">                                           
                                            <option value="Mutatá" {{ $empleoye->city === "Mutatá" ? "selected" : ""   }}>Mutatá</option>                                          
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="city_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="photo">Foto</label>
                                        <input type="file" class="form-control" id="photo" name="photo" >
                                        @if($empleoye->photo!=null)
                                        <img style="max-width:150px;margin-top: 20px;display: block;" src="{{ asset('images/empleoyes/'.$empleoye->photo.'') }}" id="phono_actual" alt="escudo">
                                      
                                        @endif
                                        <span class="missing_alert text-danger" id="photo_alert"></span>
                                        <img id="imagenPrevisualizacion" class="imagepreview">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio1" value="1" {{ ($empleoye->state=="1")? "checked" : "" }} >
                                                <label class="form-check-label" for="inlineRadio1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="inlineRadio2" value="0" {{ ($empleoye->state=="0")? "checked" : "" }}>
                                                <label class="form-check-label" for="inlineRadio2">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <a href="/students" class="btn btn-danger me-1 waves-effect waves-float waves-light " >Cancelar</a>
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" class="fa fa-save" style="margin-right: 10px;"></i> Guardar</button>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')

<script src="{{ asset('js/admin/empleoyes/edit.js') }}"></script>
@can('Subir Fotos')   
<script>
$(document).ready(function(){

        const $seleccionArchivos = document.querySelector("#photo"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

        // Escuchar cuando cambie
        $seleccionArchivos.addEventListener("change", () => {
        $('#imagenPrevisualizacion').css('display','block');
        // Los archivos seleccionados, pueden ser muchos o uno
        const archivos = $seleccionArchivos.files;
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!archivos || !archivos.length) {
        $imagenPrevisualizacion.src = "";
        return;
        }
        // Ahora tomamos el primer archivo, el cual vamos a previsualizar
        const primerArchivo = archivos[0];
        // Lo convertimos a un objeto de tipo objectURL
        const objectURL = URL.createObjectURL(primerArchivo);
        // Y a la fuente de la imagen le ponemos el objectURL
        $imagenPrevisualizacion.src = objectURL;
        });
})
</script>
@endcan
<script>
$('.delete-user').click(function(e){
    
e.preventDefault();

var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var student_id=$('#student_id').val();
Swal.fire({
title: 'Seguro que desea eliminar la imagen?',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
    $(".loadercontent").css('display','block');
    $.ajax({
      url: href,
      headers: {'X-CSRF-TOKEN': token},
      type: 'POST',
      cache: false,
      data: {student_id:student_id},
      success: function (response) {
        $(".loadercontent").fadeOut("slow");
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Imagen eliminada correctamente',
            'success'
            ).then((result) => {
                location.reload();
            });

      },error: function (data) {
        var errors = data.responseJSON;
        console.log(errors);

      }
   });

}
})

});
    </script>


@endpush
