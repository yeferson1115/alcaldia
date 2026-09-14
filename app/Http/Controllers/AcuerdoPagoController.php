<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcuerdoCliente;
use App\Models\PaymentMethod;

use Illuminate\Support\Facades\Http;

class AcuerdoPagoController extends Controller
{
    public function index()
    {
       
        return view('admin.acuerdo_pago.index');
    }

    public function search(Request $request)
{
    $user = null;

    // Validar que el campo 'document' esté presente en la consulta
    $request->validate([
        'document' => 'required|string|max:255',
    ]);

    try {
        // Realizar la autenticación
        $response = Http::withOptions([
            'verify' => false
        ])->post('https://cfinanzas.controlnextapp.com:10000/login', [
            'user' => env('CFIANZAS_USER'),
            'password' => env('CFIANZAS_PASSWORD'),
        ]);

        $token = "";

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['token'] ?? null; // Verifica si la clave 'token' existe

            // Realizar la consulta de obligaciones
            $responsecliente = Http::withOptions([
                'verify' => false
            ])->withToken($token)->post('https://cfinanzas.controlnextapp.com:10000/obligaciones', [
                'identificacion' => $request->document
            ]);

            $user = $responsecliente->json();
            
            // Procesar las obligaciones del usuario
            foreach ($user as $k1 => $item) {
                foreach ($item as $k2 => $obligacion) {
                    $mediopago = PaymentMethod::where('campaign', $obligacion['cartera'])->first();
                    $user[$k1][$k2]['medio_de_pago'] = $mediopago;
                }
            }
        } else {
            return response()->json(['error' => 'Error en la autenticación'], $response->status());
        }
    } catch (\Exception $e) {
        // Captura cualquier excepción que ocurra y devuelve un error
        return redirect()->route('acuerdo-de-pago.index')->with('error', 'Ocurrió un error al realizar la solicitud:' . $e->getMessage());
    }

    // Si el usuario no se encuentra
    if (!$user) {
        return redirect()->route('acuerdo-de-pago.index')->with('error', 'Documento no encontrado.');
    }

    $acuerdos=AcuerdoCliente::where('document',$request->document)->get();
    
    // Retornar los resultados a la vista
    return view('admin.acuerdo_pago.result', ['data' => $user, 'document' => $request->document,'acuerdos'=>$acuerdos]);
}
    public function saveDate(Request $request)
    {
        
        // Validar la fecha
        $validated = $request->validate([
            'nombrecompleto' => 'required|string',            
            'valor' => 'required|numeric',
            'cartera' => 'required|string',
            'fecha_pago' => 'required|date',
            
        ]);

        
        $acuerdo = new AcuerdoCliente([
            'document' => $request->document,
            'nombrecompleto' => $request->nombrecompleto,
            'fecha_pago' => $request->fecha_pago,
            'cuenta' => $request->cuenta,
            'cartera' => $request->cartera,
            'ciudad' => $request->ciudad,
            'valor_mora' => $request->valor_mora,
            'valor' => $request->valor
            
        ]);
        $acuerdo->save();

        if (!$acuerdo) {            
            
            return redirect()->route('acuerdo-de-pago.index')->with('error', 'Error al crear el acuerdo.');
        }

        

        // Redirigir de vuelta con un mensaje de éxito
       
        return redirect()->route('acuerdo-de-pago.index')->with('success', 'Acuerdo de pago guardado correctamente.');
    }

}
