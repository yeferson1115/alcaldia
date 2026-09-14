<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombre_deudor'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Cuota</th>
        <td>{{ number_format($client['cuota'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['max_días_mora'] }}</td>
    </tr>
    
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo_mora'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
