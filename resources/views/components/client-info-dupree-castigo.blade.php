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
        <th>Cobro</th>
        <td>$client['inicio_cobro_365']</td>
    </tr>
   
    
    
</table>
