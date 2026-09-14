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
        <th>Saldo</th>
        <td>{{ number_format($client['valor_a_cobrar'], 0, ',', '.') }}</td>
    </tr>
   
    
    
</table>
