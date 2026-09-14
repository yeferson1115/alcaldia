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
        <th>Días en Mora</th>
        <td>{{ $client['dias_mora'] }}</td>
    </tr>
  
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo_capital'], 0, ',', '.') }}</td>
    </tr>
    
 
    
</table>
