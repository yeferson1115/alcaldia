<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombre'] }}</td>
    </tr>
    <tr>
        <th>Cuota</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Cuotas Canceladas</th>
        <td>{{ $client['cuotas_can'] }}</td>
    </tr>
    <tr>
        <th>Cuotas en Mora</th>
        <td>{{ $client['cuotasmora'] }}</td>
    </tr>
   
    <tr>
        <th>Valor Cuota</th>
        <td>{{ number_format($client['vlr_cuota'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Honorarios</th>
        <td>{{ number_format($client['vlr_honorarios'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Inicial</th>
        <td>{{ number_format($client['vlr_inici'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Intereses</th>
        <td>{{ number_format($client['vlr_intereses'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Mora</th>
        <td>{{ number_format($client['vlr_mora'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
