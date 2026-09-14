@extends('layouts.app')

@section('title', 'Acuerdo de Pago')
@section('page_title', 'Acuerdo de Pago')



@section('content')

<div class="content-body">
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Estado de Cuenta</h4>
                    </div>
                    <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Obligaciones</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Acuerdos de pago</button>
                        </li>
                        
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        @if(isset($data['results']) && count($data['results']) > 0)
                        @foreach($data['results'] as $result)
                            <h2>Cartera: {{ $result['cartera'] }}</h2>
                            @foreach($result['clientData'] as $client)
                            @if($result['cartera'] === "claro")
                                <x-client-info-claro :client="$client" />
                                @endif
                                @if($result['cartera'] =="nova fianza")
                                <x-client-info-nova-fianza :client="$client" />
                                @endif
                                @if($result['cartera'] =="kiowa")
                                <x-client-info-kiowa :client="$client" />
                                @endif
                                @if($result['cartera'] =="palacio")
                                <x-client-info-palacio :client="$client" />
                                @endif
                                @if($result['cartera'] =="hogar")
                                <x-client-info-hogar :client="$client" />
                                @endif
                                @if($result['cartera'] =="dupree prej")
                                <x-client-info-dupree-prej :client="$client" />
                                @endif
                                @if($result['cartera'] =="dupree castigo")
                                <x-client-info-dupree-castigo :client="$client" />
                                @endif
                                @if($result['cartera'] =="offcorss")
                                <x-client-info-offcorss :client="$client" />
                                @endif
                                @if($result['cartera'] =="emermedica")
                                <x-client-info-emermedica :client="$client" />
                                @endif
                                @if($result['cartera'] =="flamingo")
                                <x-client-info-flamingo :client="$client" />
                                @endif
                                @if($result['cartera'] =="lebon propia")
                                <x-client-info-lebon-propia :client="$client" />
                                @endif
                                @if($result['cartera'] =="juana")
                                <x-client-info-juana :client="$client" />
                                @endif
                                @if($result['cartera'] =="tania")
                                <x-client-info-tania :client="$client" />
                                @endif
                                @if($result['cartera'] =="marketing personal")
                                <x-client-info-marketing-personal :client="$client" />
                                @endif
                                @if($result['cartera'] =="gana")
                                <x-client-info-gana :client="$client" />
                                @endif
                                @if($result['cartera'] =="fuller")
                                <x-client-info-fuller :client="$client" />
                                @endif
                                @if($result['cartera'] =="rio bravo")
                                <x-client-info-rio-bravo :client="$client" />
                                @endif
                                @if($result['cartera'] =="flamingo propia")
                                <x-client-info-flamingo-propia :client="$client" />
                                @endif
                                @if($result['cartera'] =="interactuar")
                                <x-client-info-interactuar :client="$client" />
                                @endif
                                @if($result['cartera'] =="baguer")
                                <x-client-info-baguer :client="$client" />
                                @endif
                                @if($result['cartera'] =="uribe")
                                <x-client-info-uribe :client="$client" />
                                @endif
                                @if($result['cartera'] =="sumas adminitrativo")
                                <x-client-info-uribe :client="$client" />
                                @endif
                                @if($result['cartera'] =="fondo mutuo")
                                <x-client-info-fondo-mutuo :client="$client" />
                                @endif
                                @if($result['cartera'] =="electrobello")
                                <x-client-info-electro-bello :client="$client" />
                                @endif
                                @if($result['cartera'] =="fuller peru")
                                <x-client-info-fuller-peru :client="$client" />
                                @endif
                                @if($result['cartera'] =="dupree peru")
                                <x-client-info-dupree-peru :client="$client" />
                                @endif

                                
                                
                                
                                
                                <button class="btn btn-primary mb-5 mt-3" data-bs-toggle="modal" data-bs-target="#dateModal" onclick="setClientData({{ json_encode($client) }},'{{ $result['cartera'] }}',{{ json_encode($result['medio_de_pago']) }})">
                                    Añadir Acuerdo de pago
                                </button>
                            @endforeach
                        @endforeach
                    @endif
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Estado</th>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Cuenta</th>
                                            <th>cartera</th>
                                            <th>Fecha Pago Acuerdo</th>
                                            <th>Valor Acuerdo</th>
                                            <th>Fecha Creación</th>
                                            
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
                                            <td>{{ $item->cuenta }}</td>
                                            <td>{{ $item->cartera }}</td>                                            
                                            <td>{{ $item->fecha_pago }}</td>
                                            <td>{{ number_format($item->valor, 0, ',', '.') }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modal para ingresar la fecha --}}
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">Añadir Fecha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="dateForm" method="POST" action="{{ route('acuerdo-de-pago.saveDate') }}">
                    @csrf
                    <input type="hidden" name="cons_cliente" id="cons_cliente">
                    <input type="hidden" name="ciudad" id="ciudad">
                    <input type="hidden" name="cuenta" id="cuenta">
                    <input type="hidden" name="fecha_vencimiento" id="fecha_vencimiento">
                    <input type="hidden" name="nombrecompleto" id="nombrecompleto">
                    <input type="hidden" name="saldo_documento" id="saldo_documento">
                    <input type="hidden" name="valor_mora" id="valor_mora" >
                    <input type="hidden" name="cartera" id="cartera" >
                    <input type="hidden" name="document" id="document"  value="{{$document}}">

                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor a Pagar</label>
                        <input type="text" class="form-control" id="valor" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <h4>Información de pago</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" id="pago_online"></li>
                            <li class="list-group-item" id="description"></li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Acuerdo</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
@push('scripts')
<script>
    // Función para establecer todos los datos del cliente en el formulario
    function setClientData(client,cartera,medio_de_pago) {
        var nombrecompleto="";
        var cuenta="";
        var ciudad="";
        var valor_mora="";
        $('#pago_online').text('');
        $('#description').text('');
        if(medio_de_pago.url!=null){
            $('#pago_online').text('Pago Online: '+medio_de_pago.url);
        }else{
            $('#pago_online').remove(); 
        }
        if(medio_de_pago.description!=null){
            $('#description').text(medio_de_pago.description);
        }else{
            $('#description').remove(); 
        }
        
        switch (cartera) {
        case "claro":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=client.ciudad;
            valor_mora=client.deuda_real_cuenta;
            break;
        case "nova fianza":
            nombrecompleto=client.nombre_cliente;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_capital;
            break;
        case "kiowa":
            nombrecompleto=client.nombre_completo;
            cuenta=client.cuenta;
            valor_mora=client.total_deuda;
            ciudad=null;
            break;
        case "palacio":
            nombrecompleto=client.nombre;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.vlr_mora;
            break;
        case "hogar":
            nombrecompleto=client.nombres;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.total_valor_vencido;
            break;        
        case "dupree prej":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=client.ciudad;
            valor_mora=client.saldo_documento;
            break;
        case "dupree castigo":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=client.ciudad;
            valor_mora=null;
            break;
        case "offcorss":
            nombrecompleto=client.nombre_cliente;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valor_cobrar;
            break;
        case "emermedica":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.vlr_docum;
            break;
        case "flamingo":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valor_total_mora;
            break;
        case "lebon propia":
            nombrecompleto=client.nombre;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_actual;
            break;
        case "juana":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo;
            break;
        case "tania":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_en_mora;
            break;
        case "marketing personal":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valorvencido;
            break;
        case "gana":
            nombrecompleto=client.nombre_deudor;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_mora;
            break;
        case "fuller":
            nombrecompleto=client.nombres;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.vencido;
            break;
        case "rio bravo":
            nombrecompleto=client.nombre;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valor_mora;
            break;
        case "flamingo propia":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valor_total_mora;
            break;
        case "interactuar":
            nombrecompleto=client.nombre;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_cancelacion_total;
            break;
        case "baguer":
            nombrecompleto=client.nombres;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.vencido;
            break;
        case "uribe":
            nombrecompleto=client.nombrecompleto;
            cuenta=null;
            ciudad=null;
            valor_mora=client.vlr_saldo_total;
            break;
        case "sumas adminitrativo":
            nombrecompleto=client.nombrecompleto;
            cuenta=null;
            ciudad=null;
            valor_mora=client.vlr_saldo_total;
            break;
        case "fondo mutuo":
            nombrecompleto=client.nombre;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_capital;
            break;
        case "electrobello":
            nombrecompleto=client.nombre_cliente;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.valor_a_cobrar;
            break;
        case "fuller peru":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.total_deuda;
            break;
        case "dupree peru":
            nombrecompleto=client.nombrecompleto;
            cuenta=client.cuenta;
            ciudad=null;
            valor_mora=client.saldo_total;
            break;
              
                
        default:
            console.log("Lo lamentamos, por el momento no disponemos de " + expr + ".");
        }
        // Establecer el valor de cons_cliente en el formulario
        //document.getElementById('cons_cliente').value = client.cons_cliente;
        
        
        //document.getElementById('fecha_vencimiento').value = client.fecha_vencimiento;

        document.getElementById('nombrecompleto').value = nombrecompleto;
        document.getElementById('cuenta').value = cuenta;
        document.getElementById('cartera').value = cartera;
        document.getElementById('ciudad').value = ciudad;
        document.getElementById('valor_mora').value = valor_mora;

        //document.getElementById('valor_documento').value = client.valor_documento;
        //document.getElementById('valor').value = client.saldo_documento;
        
        
        // Si quieres hacer algo con otros campos, puedes agregarlo aquí. Por ejemplo:
        console.log(client);
        // Puedes establecer más valores de cliente si es necesario, como la fecha de vencimiento
        // document.getElementById('fecha_vencimiento').value = client.fecha_vencimiento;
    }
</script>
@endpush

@endpush

