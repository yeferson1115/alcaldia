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
        <th>celular</th>
        <td>{{ $client['celular'] }}</td>
    </tr>
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['d_vencidos'] }}</td>
    </tr>
    
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Saldo Actual</th>
        <td>{{ number_format($client['saldo_actual'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
