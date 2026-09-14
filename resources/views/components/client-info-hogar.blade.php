<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombres'] }}</td>
    </tr>
    <tr>
        <th>CiuCuentadad</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Dias en Mora</th>
        <td>{{ $client['dias_mora'] }}</td>
    </tr>
    
    <tr>
        <th>Saldo Capital</th>
        <td>{{ number_format($client['saldo_capital'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Cuota</th>
        <td>{{ number_format($client['valor_cuota'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Intereses</th>
        <td>{{ number_format($client['intereses'], 0, ',', '.') }}</td>
    </tr>
  
    <tr>
        <th>Total Valor Vencido</th>
        <td>{{ number_format($client['total_valor_vencido'], 0, ',', '.') }}</td>
    </tr>
    
</table>
