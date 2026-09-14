<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombre_cliente'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Celular</th>
        <td>{{ $client['celular'] }}</td>
    </tr>
    
    <tr>
        <th>Valor</th>
        <td>{{ number_format($client['valor_cobrar'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Crédito</th>
        <td>{{ number_format($client['valor_total_credito'], 0, ',', '.') }}</td>
    </tr>
   
    <tr>
        <th>Días</th>
        <td>{{ $client['dias_sin_tramite'] }}</td>
    </tr>
  
    
</table>
