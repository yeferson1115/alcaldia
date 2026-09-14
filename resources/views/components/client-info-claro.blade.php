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
        <th>Origen</th>
        <td>{{ $client['origen'] }}</td>
    </tr>
    <tr>
        <th>Días en Mora</th>
        <td>{{ $client['dias_mora'] }}</td>
    </tr>
    <tr>
        <th>Fecha de Vencimiento</th>
        <td>{{ \Carbon\Carbon::parse($client['fecha_vencimiento'])->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <th>Monto Inicial</th>
        <td>{{ number_format($client['monto_inicial'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Monto Inicial Cuenta</th>
        <td>{{ number_format($client['mod_init_cta'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Deuda Real</th>
        <td>{{ number_format($client['deuda_real_cuenta'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th>Número de Cuenta</th>
        <td>{{ $client['cuenta'] }}</td>
    </tr>
    <tr>
        <th>Referencia</th>
        <td>{{ $client['referencia'] }}</td>
    </tr>
    
</table>
