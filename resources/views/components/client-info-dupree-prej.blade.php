<!-- resources/views/components/client-info.blade.php -->

<table class="table">
    <tr>
        <th>Nombre Completo</th>
        <td>{{ $client['nombrecompleto'] }}</td>
    </tr>
    <tr>
        <th>Ciudad</th>
        <td>{{ $client['ciudad'] }}</td>
    </tr>
    <tr>
        <th>Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
   
    <tr>
        <th>Fecha de Vencimiento</th>
        <td>{{ \Carbon\Carbon::parse($client['fecha_vencimiento'])->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <th>Saldo</th>
        <td>{{ number_format($client['saldo_documento'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Monto Inicial Cuenta</th>
        <td>{{ number_format($client['mod_init_cta'], 0, ',', '.') }}</td>
    </tr>
    
    
</table>
