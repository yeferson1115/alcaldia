<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombres'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['mora'] }}</td>
    </tr>
    
    <tr>
        <th>Vencido</th>
        <td>{{ number_format($client['vencido'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
