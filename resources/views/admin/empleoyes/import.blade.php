@extends('layouts.app')
@section('title','Empleados')
@section('page_title', 'Importar empleados')
@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Importar Empleados</h2>
                
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
                            <input type="hidden" id="_url" value="{{ route('importstudientssave') }}">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="file">Archivo</label>
                                        <input type="file" class="form-control" id="file" name="file" >
                                        <span class="missing_alert text-danger" id="file_alert"></span>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-1 mt-3">
                                        <a  class="mb-1 mt-2 btn btn-success waves-effect waves-float waves-light" href="{{ asset('plantillas/plantilla_empleados.xlsx') }}" title="Editar" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Formato </a>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" style="margin-right: 10px;"  class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                        <h2 class="mt-5">Ayudas</h2>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Codigos Dependencias
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="alert alert-warning mt-4" role="alert" style="padding: 7px;">
                                            En la columna <strong>area_id</strong> del archivo, debe ingresar el número correspondiente a la columna <strong>id</strong> de la <strong>dependencia</strong> correspondiente de la siguiente tabla:
                                        </div>
                                        <table class="table mt-1">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Grupo</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($areas as $item)
                                                    <tr class="odd row{{ $item->id }}">
                                                        <td>{{ $item->id }} </td>
                                                        <td>{{ $item->name }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingcampus">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecampus" aria-expanded="true" aria-controls="collapsecampus">
                                        Codigos Cargos
                                    </button>
                                </h2>
                                <div id="collapsecampus" class="accordion-collapse collapse" aria-labelledby="headingcampus" data-bs-parent="#accordionExample">
                                    <div class="accordion-body mt-3">
                                        <div class="alert alert-warning mt-4" role="alert" style="padding: 7px;">    
                                            En la columna <strong>role_id</strong> del archivo, debe ingresar el número correspondiente a la columna <strong>id</strong> de la siguiente tabla:
                                        </div>
                                        <table class="table mt-1">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($charges as $item)
                                                    <tr class="odd row{{ $item->id }}">
                                                        <td>{{ $item->id }} </td>
                                                        <td>{{ $item->name }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCity">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCity" aria-expanded="false" aria-controls="collapseCity">
                                        Ciudades
                                    </button>
                                </h2>
                                <div id="collapseCity" class="accordion-collapse collapse" aria-labelledby="headingCity" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="alert alert-warning mt-4" role="alert" style="padding: 7px;">     
                                            En la columna <strong>ciudad</strong> del archivo, unicamente debe ingresar uno de los siguientes Valores tal cual estan en la siguiente tabla:
                                        </div>
                                        <table class="table mt-1">
                                            <thead>
                                                <tr>
                                                    <th>Ciudad</th>                                                
                                                </tr>
                                            </thead>
                                            <tbody>                                           
                                                <tr class="odd row">                                                    
                                                    <td>Medellín</td>                                                   
                                                </tr>
                                                <tr class="odd row">                                                    
                                                    <td>Bogotá</td>                                                   
                                                </tr>                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Codigos Tipo documento
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="alert alert-warning mt-4" role="alert" style="padding: 7px;">     
                                            En la columna <strong>tipo_documento</strong> del archivo, unicamente debe ingresar uno de los siguientes Valores de la siguiente tabla:
                                        </div>
                                        <table class="table mt-1">
                                            <thead>
                                                <tr>
                                                    <th>Tipo Documento</th>                                                
                                                </tr>
                                            </thead>
                                            <tbody>                                           
                                                <tr class="odd row">
                                                    <!--<td>RC</td>
                                                    <td>TI</td>-->
                                                    <td>CC</td>
                                                    <!--<td>NES</td>
                                                    <td>PEP</td>
                                                    <td>DO-V</td>-->
                                                    <td>PPT</td>
                                                    <!--<td>CE</td>
                                                    <td>NIP</td>-->
                                                    
                                                    
                                                </tr>                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   Codigos RH
                                </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                <div class="alert alert-warning mt-4" role="alert" style="padding: 7px;"> 
                                    En la columna <strong>RH</strong> del archivo, unicamente debe ingresar uno de los siguientes Valores de la siguiente tabla:
                                </div>
                                <table class="table mt-1">
                                        <thead>
                                            <tr>
                                                <th>RH</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>                                           
                                            <tr class="odd row">
                                                <td>A+</td>
                                                <td>O+</td>
                                                <td>B+</td>
                                                <td>AB+</td>
                                                <td>A-</td>
                                                <td>O-</td>
                                                <td>B-</td>
                                                <td>AB-</td>
                                                <td>N/A</td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')

    <script src="{{ asset('js/admin/empleoyes/import.js') }}"></script>

@endpush
