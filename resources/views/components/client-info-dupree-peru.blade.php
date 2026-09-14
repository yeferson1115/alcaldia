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
        <th>Saldo</th>
        <td>{{ number_format($client['saldo_total'], 0, ',', '.') }}</td>
    </tr>
   
    
    
</table>
