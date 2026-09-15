@extends('layouts.app')
@section('title','Empleados')
@section('page_title', 'Listado de empleados')
@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Empleados</h2>
                
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
            
                @can('Crear Personal')
                    <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3"> <i class="ti ti-plus"></i> Crear Empleado</a>   
                    <a href="{{ url('importempleoyes') }}" class="mb-2 btn btn-warning waves-effect waves-float waves-light"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Importar Empleados</a>                 
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
                    
                    <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                        <div class="table-responsive">
                            <table class="table " id="yajra-datatable" >
                                <thead>
                                    <tr >
                                        <th >#</th>
                                        <th>Action</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Documento</th>
                                        <th>Dependencia</th>
                                        <th>Cargo</th>
                                        <th>RH</th>
                                        <th>Foto</th>
                                        <th>Ciudad</th>
                                    </tr>
                                </thead>
                                <tbody>
                               
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<input type="hidden" id="_token" value="{{ csrf_token() }}">


@endsection
@push('scripts')
<script>
     function elimanar(e){
        
        
        let href = $(e).attr('data-attr');// Don't post the form, unless confirmed
        let token = $('#_token').val();
        //var data=$(e.target).closest('form').serialize();
        Swal.fire({
        title: 'Seguro que desea eliminar el empleado?',
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
              success: function (response) {
                
                if (response.status === 'success') {
                  // Mostrar mensaje de éxito                 
                  _alertGeneric('success','Success',response.message,'/empleados');
                  
                }else{                  
                    _alertGeneric('info','Error',response.message,null);
                }
              },
              error: function(xhr, status, error) {
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

        }
        })
    }
$(document).ready(function() {
    $('#yajra-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('empleoyeslist') }}",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},             
        {
            data: 'action', 
            name: 'action', 
            orderable: true, 
            searchable: true
        },
        {data: 'name', name: 'name'}, 
        {data: 'last_name', name: 'last_name'}, 
        {data: 'document', name: 'document'}, 
        {data: 'area.name', name: 'area'}, 
        {data: 'charge.name', name: 'charge'},
        {data: 'rh', name: 'rh'},
        
        {
        name: "image",
        data: "photo",
        render: function (data, type, full, meta) {
            return "<img src=images/empleoyes/" + data + " height=\"50\"/>";
        },
        "title": "Foto",
        "orderable": true,
        "searchable": true
        },
        {data: 'city', name: 'city'},

        
     
    ],

    "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    destroy: true,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    
});

});
</script>



@endpush
