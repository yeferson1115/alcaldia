<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombrecompleto'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
   
    <tr>
        <th>Saldo en Mora</th>
        <td>{{ number_format($client['saldo_en_mora'], 0, ',', '.') }}</td>
    </tr>
   
    <tr>
        <th>Cuotas Pendientes</th>
        <td>{{ $client['cuotas_pendientes'] }}</td>
    </tr>
    <tr>
        <th>No. Credito</th>
        <td>{{ $client['num_credito'] }}</td>
    </tr>
    
</table>
