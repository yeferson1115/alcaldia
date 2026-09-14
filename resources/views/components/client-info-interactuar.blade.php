<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombre'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Cuotas Vencidas</th>
        <td>{{ $client['cuotas_vencidas'] }}</td>
    </tr>
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['numero_de_dias_de_mora'] }}</td>
    </tr>
    
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo_cancelacion_total'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
