@extends('layouts.app')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')

@push('styles')
<style type="text/css">
    .content-icono{
        text-align: center;
        font-size: 60px;
        color:#7367f0;
        margin-bottom: 0px !important;
    }
    .card-title {
        text-align: center;
    }
    p{
        text-align: center;
    }
    .title{
      text-align: center;
    color: #7367f0;
    margin-bottom: 15px;
    font-size: 60px;

    }
    .desc{
      margin-bottom: 60px;
    }
</style>
@endpush

@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              
                <h2 class="title">Control de Asistencia</h2>
                <p class="desc">Gestión eficiente y análisis detallado de Asistencia</p>

                <!-- Total Profit -->
                <div class="col-xl-4 col-md-4 col-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="p-2 content-icono mb-2">
                            <i class="fa-regular fa-address-card"></i>
                        </div>
                        <h5 class="card-title mb-1 pt-2">Registro de Asistencia</h5>
                        <p class="text-muted mb-4">Registro de entrada y salida de empleados de una manera ágil.</p>

                        <!-- Contenedor flex para centrar el botón -->
                        <div class="d-flex justify-content-center">
                        @if(auth()->user()->id==1 || auth()->user()->id==3 || auth()->user()->id==5 || auth()->user()->id==6 || auth()->user()->id==8 || auth()->user()->id==9)
                            <a href="/scanner-entradas-salidas" class="btn rounded-pill btn-outline-primary waves-effect mt-5">Registrar</a>
                        @endif
                        </div>
                        </div>
                    </div>
                </div>


                <!-- Total Profit -->
                
                <div class="col-xl-4 col-md-4 col-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="p-2 content-icono mb-2">
                          <i class="fa-regular fa-chart-bar"></i>
                        </div>
                        <h5 class="card-title mb-1 pt-2">Reporte Detallado</h5>
                        <p class="text-muted mb-4">Analiza datos con reportes exportables en tiempo real.</p>

                        <!-- Contenedor flex para centrar el botón -->
                        <div class="d-flex justify-content-center">                       
                            <a href="/reportes" class="btn rounded-pill btn-outline-primary waves-effect mt-5">Ver Reporte</a>
                        </div>
                      </div>
                    </div>
                </div>

             <!-- Total Profit -->
             <div class="col-xl-4 col-md-4 col-6">
                    <div class="card">
                        <div class="card-body">
                        <div class="p-2 content-icono mb-2">
                          <i class="fa-regular fa-user"></i>
                        </div>
                        <h5 class="card-title mb-1 pt-2">Gestión de Usuarios</h5>
                        <p class="text-muted mb-4">Administra roles y permisos de los usuarios d ela plataforma</p>

                        <!-- Contenedor flex para centrar el botón -->
                        <div class="d-flex justify-content-center">                       
                            <a href="/user" class="btn rounded-pill btn-outline-primary waves-effect mt-5">gestionar</a>
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

@endpush

