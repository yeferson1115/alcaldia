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
        <th>Saldo Capital</th>
        <td>{{ number_format($client['saldo_capital'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Número Cuotas</th>
        <td>{{ $client['numero_de_cuotas'] }}</td>
    </tr>
    <tr>
        <th>Rango de Mora</th>
        <td>{{ $client['rango_de_mora'] }}</td>
    </tr>
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['dias_de_mora'] }}</td>
    </tr>
    <tr>
        <th>Número de Cuotas Canceladas</th>
        <td>{{ $client['numero_de_cuotas_canceladas'] }}</td>
    </tr>
    
    
</table>
