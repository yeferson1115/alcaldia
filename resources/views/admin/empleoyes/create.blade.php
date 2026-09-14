@extends('layouts.app')

@section('title', 'Empleados')
@section('page_title', 'Crear Empleado')
@section('page_subtitle', 'Guardar')
@section('content')

<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Empleados</h2>
                
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
                            <input type="hidden" id="_url" value="{{ url('empleados') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="area_id">Area</label>                                        
                                        <select class="invoiceto1 form-select customer" id="area_id" name="area_id" readonly>
                                            <option value="">Seleccione</option>                                            
                                            @foreach ($areas as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="role_id_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombres">
                                        <span class="missing_alert text-danger" id="name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="last_name">Apellidos</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos">
                                        <span class="missing_alert text-danger" id="last_name_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type_document">Tipo de documento</label>
                                        <select class="invoiceto1 form-select customer" id="type_document" name="type_document">                                            
                                            <option value="">Seleccione</option>
                                            <!--<option value="RC">R.C</option>
                                            <option value="TI">T.I</option>-->
                                            <option value="CC">C.C</option>
                                            <!--<option value="NES">NES</option> 
                                            <option value="PEP">PEP</option> 
                                            <option value="DO-V">DO-V</option>-->
                                            <option value="PPT">PPT</option> 
                                            <!--<option value="CE">CE</option>  
                                            <option value="NIP">NIP</option>  
                                            <option value="OD">OD</option>
                                            <option value="NUIP">NUIP</option>-->
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="type_document_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="document">No. Documento</label>
                                        <input type="text" class="form-control" id="document" name="document" placeholder="No. Documento">
                                        <span class="missing_alert text-danger" id="document_alert"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Genero</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexm" value="M" >
                                                <label class="form-check-label" for="sexm">M</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexf" value="F">
                                                <label class="form-check-label" for="sexf">F</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="sexOtro" value="Otro" >
                                                <label class="form-check-label" for="sexOtro">Otro</label>
                                            </div>
                                        </div>
                                        <span class="missing_alert text-danger" id="sex_alert"></span>
                                    </div>
                                </div>    
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone">Teléfono</label>
                                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Télefono">
                                        <span class="missing_alert text-danger" id="phone_alert"></span>
                                    </div>
                                </div>   
                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="rh">R.H</label>                                        
                                        <select class="invoiceto1 form-select customer" id="rh" name="rh">
                                           <option value="">Seleccione</option> 
                                            <option value="A+">A+</option>
                                            <option value="O+">O+</option>
                                            <option value="B+">B+</option>
                                            <option value="AB+">AB+</option>
                                            <option value="A-">A-</option>
                                            <option value="O-">O-</option>
                                            <option value="B-">B-</option>
                                            <option value="AB-">AB-</option>
                                            <option value="N/A">N/A</option>
                                            
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="rh_alert"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city">Ciudad</label>
                                        <select class="invoiceto1 form-select customer" id="city" name="city">                                           
                                            <option value="Mutatá">Mutatá</option>                                            
                                        </select>                                       
                                        <span class="missing_alert text-danger" id="city_alert"></span>
                                    </div>
                                </div>

                                
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="photo">Foto</label>
                                        <input type="file" class="form-control" id="photo" name="photo" >
                                        <span class="missing_alert text-danger" id="photo_alert"></span>
                                        <img id="imagenPrevisualizacion" class="imagepreview" style="width: 100%;">
                                    </div>
                                </div>
                              

                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="city-column">Estado</label>
                                        <div class="demo-inline-spacing">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="stateinstitution1" value="1" checked="">
                                                <label class="form-check-label" for="stateinstitution1">Activo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="state" id="stateinstitution2" value="0">
                                                <label class="form-check-label" for="stateinstitution2">Inactivo</label>
                                            </div>
                                        </div>
                                        <span class="missing_alert text-danger" id="state_alert"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" style="margin-right: 10px;" class="fa fa-save"></i> Guardar</button>
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

    <script src="{{ asset('js/admin/empleoyes/create.js') }}"></script>
 
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
    });
</script>


@endpush
