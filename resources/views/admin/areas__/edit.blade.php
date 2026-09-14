@extends('layouts.app')

@section('title', 'Editar Acuerdo de Pago')
@section('page_title', 'Editar Acuerdo de Pago')

@section('content')

<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Editar Acuerdo de Pago</h2>
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
                        <h4 class="card-title">Editar Acuerdo de Pago #{{$acuerdo->id}}</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- Formulario de edición -->
                        <form method="POST" action="{{ route('acuerdos-de-pago.update', $acuerdo->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="{{ old('fecha_pago', $acuerdo->fecha_pago->format('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="valor" class="form-label">Valor a Pagar</label>
                                <input type="text" class="form-control" id="valor" name="valor" value="{{ old('valor', $acuerdo->valor) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="state" class="form-label">Estado</label>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="Pendiente de pago" {{ old('state', $acuerdo->state) == 'Pendiente de pago' ? 'selected' : '' }}>Pendiente de pago</option>
                                    <option value="No Pago" {{ old('state', $acuerdo->state) == 'No Pago' ? 'selected' : '' }}>No Pago</option>
                                    <option value="Pagado" {{ old('state', $acuerdo->state) == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Acuerdo</button>
                            <a href="{{ route('acuerdos-de-pago.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
    // Si deseas agregar algún script para formatear el valor o cualquier otra cosa, puedes hacerlo aquí.
</script>
@endpush
