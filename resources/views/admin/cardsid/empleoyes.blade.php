@extends('layouts.app')
@section('title','Carnets Estudiantes')
@section('page_title', 'Listado de empleado')
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
                    <form class="form" role="form" action="javascript:void(0)"  id="main-form" autocomplete="off">
                        <input type="hidden" id="_url" value="{{ url('carnets-empleados') }}">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        
                                        
                        <ul class="list-group mb-5">
                            <li class="list-group-item"><input type="checkbox"  class="form-check-input m-1"  onclick="selectall(this);" >Todo</li>
                            @foreach ($empleoyes as $key=>$item)
                             @if($item->photo!=null)
                                <li class="list-group-item"><input type="checkbox"  name="empleoye_id[]" class="form-check-input m-1 empleado" value="{{$item->id}}"><b>Documento:</b> {{$item->document}} - <b>Empleado:</b> {{$item->last_name}} {{$item->name}} - <b>Cargo:</b> {{$item->charge->name}}</li>
                                @endif
                            @endforeach                                       
                        </ul>
                                        
                           
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax" id="submit"><i id="ajax-icon" style="margin-right: 10px;" class="fa fa-save"></i> Generar Carnets</button>
                        </div>                            
                    </form>                   
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')
<script>
    function selectall(e){
        
        if ($(e).prop('checked')) {
            $(".empleado").click();
        } else {
            $(".empleado").click();
        }
        
    }
  
</script>
<script src="{{ asset('js/admin/cardids/create.js') }}"></script>
@endpush
