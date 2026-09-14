@extends('layouts.app')

@section('title', 'Acuerdos de Pago')
@section('page_title', 'Acuerdos de Pago')

@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Acuerdos de Pago</h2>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Acuerdos de pago</h4>
                    </div>
                    <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Ciudad</th>
                                    <th>Cuenta</th>
                                    <th>cartera</th>
                                    <th>Saldo</th>
                                    <th>Fecha Pago Acuerdo</th>
                                    <th>Valor Acuerdo</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($acuerdos as $item)
                                <tr>
                                    <td>
                                        @if($item->state=='Pagado')
                                        <span class="badge bg-success">Pagado</span>
                                        @endif
                                        @if($item->state=="No Pago")
                                        <span class="badge bg-danger">No Pago</span>
                                        @endif
                                        @if($item->state=="Pendiente de pago")
                                        <span class="badge bg-info">Pendiente de pago</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->nombrecompleto }}</td>
                                    <td>{{ $item->document }}</td>
                                    <td>{{ $item->ciudad }}</td>
                                    <td>{{ $item->cuenta }}</td>
                                    <td>{{ $item->cartera }}</td>
                                    <td>{{ number_format($item->valor_mora, 0, ',', '.') }}</td>
                                    <td>{{ $item->fecha_pago }}</td>
                                    <td>{{ number_format($item->valor, 0, ',', '.') }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        @can('Editar Acuerdo de Pago')
                                        <a href="/acuerdos-de-pago/{{$item->id}}/edit" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                                        @endcan
                                        @can('Eliminar Acuerdo de pago')
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $item->id }}"><i class="ti ti-trash"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este acuerdo de pago? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" action="" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script para cargar la ID del acuerdo en el formulario de eliminación cuando se abre el modal
    var deleteModal = document.getElementById('confirmDeleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // El botón que activó el modal
        var acuerdoId = button.getAttribute('data-id'); // Obtiene la ID del acuerdo

        var form = document.getElementById('deleteForm');
        form.action = '/acuerdos-de-pago/' + acuerdoId; // Configura la acción del formulario con la URL correcta
    });
</script>
@endpush