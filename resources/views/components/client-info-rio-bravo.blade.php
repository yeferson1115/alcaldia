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
        <th>Valor en Mora</th>
        <td>{{ number_format($client['valor_mora'], 0, ',', '.') }}</td>
    </tr>
   
    
</table>
