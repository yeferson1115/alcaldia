@extends('layouts.app')

@section('title', 'Personal')
@section('page_title', 'Areas')



@section('content')
<div class="content-header row mt-5">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Scanner Entradas y Salidas</h2>
                
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
                    <!-- Este campo es invisible, pero captura la entrada del lector USB -->
                     <label>Codigo Empleado</label>
                    <input type="text" id="qr-input" class="form-control" autofocus />

                    <div id="result"></div>
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
        // Obtener el campo de entrada para el lector USB
       const qrInput = document.getElementById("qr-input");
let scanTimeout;

qrInput.addEventListener("input", function() {
    clearTimeout(scanTimeout); // Limpiar temporizador previo

    scanTimeout = setTimeout(() => {
        const qrText = qrInput.value.trim();
        if (qrText) {
            enviarQR(qrText);
        }
    }, 500); // Espera 500ms después del último caracter ingresado
});

function enviarQR(qrText) {
    document.getElementById("result").innerText = `Código QR Escaneado: ${qrText}`;

    $.ajax({
        url: "{{ url('scanner-entradas-salidas') }}",
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        type: 'POST',
        data: { document: qrText },
        success: function(response) {
            qrInput.value = "";
            qrInput.focus();
            _alertGeneric('success', 'Éxito', response.message, null, 30);
        },
        error: function(xhr) {
            qrInput.value = "";
            qrInput.focus();
            let message = xhr.status === 422 ? Object.values(xhr.responseJSON.errors).map(e => e[0]).join('\n') : xhr.responseJSON.message;
            _alertGeneric('error', 'Error', message, null, 30);
        }
    });
}

// Enfocar automáticamente el campo de entrada al cargar la página
window.onload = function() {
    qrInput.focus();
};


        
    </script>

@endpush

