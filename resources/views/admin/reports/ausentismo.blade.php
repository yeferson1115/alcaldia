@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header  text-white">
            <h4 class="mb-0">📊 Reporte de Ausentismo</h4>
        </div>
        <div class="card-body">
            {{-- FILTROS --}}
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Fecha inicio</label>
                    <input type="date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Fecha fin</label>
                    <input type="date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6 text-end">
                    <button id="filterBtn" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <button id="exportBtn" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
                    </button>
                </div>
            </div>

            {{-- PRELOADER --}}
            <div id="preloader" class="text-center my-3" style="display:none;">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2 fw-bold text-primary">Cargando información...</p>
            </div>

            {{-- TABLA --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center" id="ausentismo-table" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Documento</th>
                            <th>Dependencia</th>
                            <th>Trabajado mañana</th>
                            <th>Ausente mañana</th>
                            <th>Trabajado tarde</th>
                            <th>Ausente tarde</th>
                            <th>Total trabajado</th>
                            <th>Total ausente</th>
                            <th>Estado</th>
                            <th>Notas (marcas)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    let table = $('#ausentismo-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('reports.ausentismo.data') }}",
            data: function(d){
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            },
            beforeSend: function(){
                $("#preloader").show();
            },
            complete: function(){
                $("#preloader").hide();
            }
        },
        columns: [
            { data: 'fecha' },
            { data: 'empleado' },
            { data: 'documento' },
            { data: 'area' },
            { data: 'trabajado_manana' },
            { data: 'ausente_manana' },
            { data: 'trabajado_tarde' },
            { data: 'ausente_tarde' },
            { data: 'total_trabajado' },
            { data: 'total_ausente' },
            { data: 'estado',
              render: function(data){
                  if(data === 'COMPLETO') return '<span class="badge bg-success">'+data+'</span>';
                  if(data === 'INCOMPLETO') return '<span class="badge bg-warning">'+data+'</span>';
                  return '<span class="badge bg-danger">'+data+'</span>';
              }
            },
            { data: 'notas' },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        }
    });

    $('#filterBtn').on('click', function(){
        table.ajax.reload();
    });

    $('#exportBtn').on('click', function(){
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        $("#preloader").show();
        let url = "{{ route('reports.ausentismo.export') }}?start_date=" + start + "&end_date=" + end;
        window.location = url;
        setTimeout(() => $("#preloader").hide(), 2000); // ocultar después de 2s
    });
});
</script>
@endpush
