<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombre_completo'] }}</td>
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
        <th>Modalidad</th>
        <td>{{ $client['modalidad'] }}</td>
    </tr>
    <tr>
        <th>Modalidad</th>
        <td>{{ $client['cuotas_pendientes'] }}</td>
    </tr>
    <tr>
        <th>Valor Cuota</th>
        <td>{{ number_format($client['valor_cuota'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Saldo Garantia</th>
        <td>{{ number_format($client['saldo_garantia'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Total Deudad</th>
        <td>{{ number_format($client['total_deuda'], 0, ',', '.') }}</td>
    </tr>
    
    <tr>
        <th>No Crédito</th>
        <td>{{ $client['nrocredito_origen'] }}</td>
    </tr>
    
</table>
