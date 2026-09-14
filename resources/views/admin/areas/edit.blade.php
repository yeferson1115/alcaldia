@extends('layouts.app')

@section('title', 'Personal')
@section('page_title', 'Dependencias')
@section('page_subtitle', 'Editas')
@section('content')


<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar Dependencia</h2>
                
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
                    <form class="form" action="javascript:void(0)" role="form" id="main-form" autocomplete="off">
                        <input type="hidden" id="_url" value="{{ url('areas',[$areas->id]) }}">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        
                        <div class="row">                           
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ $areas->name }}">
                                    <span class="missing_alert text-danger" id="name_guardian_alert"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="city-column">Estado</label>
                                    <div class="demo-inline-spacing">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="state" id="status1" value="1" {{ ($areas->state=="1")? "checked" : "" }}>
                                            <label class="form-check-label" for="status1">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="state" id="status2" value="0" {{ ($areas->state=="0")? "checked" : "" }}>
                                            <label class="form-check-label" for="status2">Deshabilitado</label>
                                        </div>
                                    </div>
                                    <span class="missing_alert text-danger" id="state_guardian_alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 form-check">
                                    <input class="form-check-input" type="checkbox" id="can_take_attendance_from_any_dependency" name="can_take_attendance_from_any_dependency" value="1" {{ $areas->can_take_attendance_from_any_dependency ? 'checked' : '' }}>
                                    <label class="form-check-label" for="can_take_attendance_from_any_dependency">Permitir que los usuarios de esta dependencia tomen asistencia de cualquier dependencia</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')
<script src="{{ asset('js/admin/areas/edit.js') }}"></script>
@endpush
