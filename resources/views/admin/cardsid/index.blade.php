@extends('layouts.app')
@section('title','Carnets')
@section('page_title', 'Listado de carnets')
@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Carnets</h2>
                
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
            
                @can('Crear Carnets')
                    <a href="{{ route('carnets-empleados.create') }}" class="btn btn-primary mb-3"> <i class="ti ti-plus"></i> Crear Carnets</a>                    
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card"> 
                    <div class="mb-5 mt-4 ml-3">
                    @php
                        $archivo = public_path('carnets.zip'); 
                    @endphp

                    @if (file_exists($archivo))
                        <a href="{{ asset('carnets.zip') }}" style="margin-left: 20px;" class="btn btn-primary" target="_blank">
                        <i class="fa-solid fa-file-zipper" style="margin-right: 7px;"></i> Descargar ZIP
                        </a>
                    @endif
                    </div>                   
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table" id="datatables" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" >#</th>
                                        <th class="sorting" >Acciones</th>
                                        <th class="sorting" >Empleado</th>   
                                        <th class="sorting" >Documento</th>                                      
                                        <th class="sorting" >Imagen</th>
                                        <th class="sorting" >Fecha Creacion</th>
                                        <th class="sorting" >Usuario Creacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($cards as $item)
                                    <tr class="odd row{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td> 
                                            <form method="POST" action="">
                                                <div class="form-group">
                                                    <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('/carnets-empleados',[$item->id]) }}" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="fa-solid fa-trash-can"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>@if($item->empleado!=null){{ $item->empleado->name }} {{ $item->empleado->last_name }}@endif</td>
                                        <td>@if($item->empleado!=null){{ $item->empleado->document }}@endif</td>
                                        <td> 
                                            <a  class="mb-1 btn btn-warning waves-effect waves-float waves-light" href="{{ asset($item->carnet) }}" title="Ver Carnet" target="_blank"><i class="fa-solid fa-image"></i> </a>
                                            <a class="mb-1 btn btn-success waves-effect waves-float waves-light" href="{{ asset($item->carnet) }}" download title="Descargar Carnet"><i class="fa-solid fa-download"></i></a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>@if($item->user!=null){{ $item->user->name }} {{ $item->user->lastname }} @endif</td>                                      

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@push('scripts')
<script>
   $('.delete-user').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
Swal.fire({
title: 'Seguro que desea eliminar el archivo de carnets?',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
    $.ajax({
      url: href,
      headers: {'X-CSRF-TOKEN': token},
      type: 'DELETE',
      cache: false,
      data: data,
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Carnets eliminados correctamente',
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
