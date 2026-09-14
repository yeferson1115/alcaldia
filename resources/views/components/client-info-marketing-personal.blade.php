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
        <th>Valor Vencido</th>
        <td>{{ number_format($client['valorvencido'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Valor Intereces Mora</th>
        <td>{{ number_format($client['valintmora'], 0, ',', '.') }}</td>
    </tr>

    <tr>
        <th>Saldo Total</th>
        <td>{{ number_format($client['saldo_total'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
