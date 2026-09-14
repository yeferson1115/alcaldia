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
        <th>Días en Mora</th>
        <td>{{ $client['dias_de_mora'] }}</td>
    </tr>
  
    <tr>
        <th>Valor Vencido</th>
        <td>{{ number_format($client['valor_vencido'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Total en Mora</th>
        <td>{{ number_format($client['valor_total_mora'], 0, ',', '.') }}</td>
    </tr>
 
    
</table>
