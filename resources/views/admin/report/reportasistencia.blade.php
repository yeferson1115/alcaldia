@extends('layouts.app')
@section('title','Reportes')
@section('page_title', 'Reporte de Asistencia')
@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Reporte Asistencia e Inasistencia</h2>
                
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
                        <div class="row">
                            
                            <div class="col-md-3">
                                <div class="category-filter mt-2 mb-4">
                                    <label class="form-label" for="date">Desde</label>
                                    <input type="date" id="date_start" class="form-control" name="date_start">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="category-filter mt-2 mb-4">
                                    <label class="form-label" for="date">Hasta</label>
                                    <input type="date" id="date_end" class="form-control" name="date_end">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="category-filter mt-2 mb-4">
                                    <label class="form-label" for="city">Ciudad</label>
                                    <select class="invoiceto1 form-select customer" id="city" name="city">                                             
                                        <option value="Mutatá">Mutatá</option>                                           
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light ajax mt-4" id="search"><i id="ajax-icon" class="fa fa-search"></i> Consultar</button>
                            </div>

                        </div>

                    <div class="table-responsive">
                            <table class="table" id="yajra-datatable" >
                                <thead class="table-light">
                                    <tr >
                                        <th class="sorting" >#</th>
                                        <th class="sorting" ></th>
                                        <th class="sorting" >Nombre</th> 
                                        <th class="sorting" >Apellido</th> 
                                        <th class="sorting" >Documento</th> 
                                        <th class="sorting" >Dependencia</th>
                                        <th class="sorting" >Cargo</th>
                                        <th class="sorting" >Fecha</th>
                                        <th class="sorting" >Ciudad</th>

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

@endsection

@push('scripts')
<script>
   $("#search").click(function(){
   
    var datesearch=$('#date_start').val();
    var date_end=$('#date_end').val();
    var city=$('#city').val();
    if(datesearch!='' && date_end!='' && city!=''){
        var table = $('#yajra-datatable').DataTable();
        table.destroy();
        $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('reportasistenciaempleoyeslist') }}",
                data: {'date_start':$('#date_start').val(),'date_end':$('#date_end').val(),'city':$('#city').val()}
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    name: "asistio",
                    data: "asistio",
                    render: function (data, type, full, meta) {
                        if(data==1){
                            return '<span class="badge  text-white bg-success">Asistio</span>';
                        }
                        if(data==0){
                            return '<span class="badge  text-white bg-danger">No asistio</span>';
                        }
                    
                    },
                    "title": "Evento",
                    "orderable": true,
                    "searchable": true
                },
                {data: 'name', name: 'name'}, 
                {data: 'last_name', name: 'last_name'}, 
                {data: 'document', name: 'document'}, 
                {data: 'area.name', name: 'area'},
                {data: 'charge.name', name: 'cargo'},
                {
                    name: "fecha",
                    data: "fecha",
                    render: function (data, type, full, meta) {
                        return '<label>'+moment(data).format('YYYY-MM-DD')+'</label>';
                    },
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
            dom: 'Bfrtip',
        "buttons": [
                    {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Reporte',
                className:'btn btn-success btnexel',
                "action": newexportaction
            }
        ],
    });
       

    }else{
        _alertGeneric('info','Información','Debe seleccionar fecha inicial, final y ciudad',null); 
    }
    });




function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
</script>

@endpush

