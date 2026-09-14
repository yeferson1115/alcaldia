<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombrecompleto'] }}</td>
    </tr>
    <tr>
        <th>Saldo en Mora</th>
        <td>{{ number_format($client['vlr_saldo_total'], 0, ',', '.') }}</td>
    </tr>
    
</table>
