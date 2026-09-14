<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Empleoyes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');       
        $this->middleware('permission:Scaner QR', ['only' => ['index',]]);
        $this->middleware('permission:Scaner QR', ['only' => ['create', 'store']]);
        
    }
    // Mostrar lista de medios de pago
    public function index()
    {
        return view('admin.scanner.index');
    }

    // Mostrar el formulario para crear un nuevo medio de pago
    public function create()
    {
        return view('admin.payment_methods.create');
    }

    // Almacenar un nuevo medio de pago
    public function store(Request $request)
    {
        // Validar el request
        $validator = Validator::make($request->all(), [           
            'document' => 'required|string',             
        ]);

        // Si la validación falla, retornar respuesta de error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // Código de estado 422 para errores de validación
        }

        // Intentamos realizar la operación
        try {
            // Buscar el empleado por documento
            $empleoye = Empleoyes::with('area')->where('id', $request->document)->first();
            
            if (!$empleoye) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró el empleado.',
                ], 404);  
            }

            // Buscar la última asistencia del empleado
            $asistencia = Attendance::where('empleoye_id', $empleoye->id)
                                    ->latest()
                                    ->first();

            // Determinar el tipo de asistencia (entrada o salida)
            $type = $asistencia ? ($asistencia->type == 1 ? 0 : 1) : 1; // Si no hay asistencia, la primera será "entrada"

            // Crear un nuevo registro de asistencia
            Attendance::create([
                'empleoye_id' => $empleoye->id,
                'type' => $type,
                'name' => $empleoye->name,
                'last_name' => $empleoye->last_name,
                'document' => $empleoye->document,
                'area' => $empleoye->area->name,
            ]);

            // Retornar respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Asistencia registrada correctamente.',
            ], 200); // Código de estado 200 para éxito

        } catch (\Exception $e) {
            // Si hay un error al intentar procesar la solicitud
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar la asistencia: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }
    }


    // Mostrar el formulario para editar un medio de pago
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    // Actualizar un medio de pago existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'campaign' => 'required|string|max:255',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,tiff|max:4096', // Validación para imagen
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);

        // Si hay una nueva imagen, manejar la carga de la imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen antigua si existe
            if ($paymentMethod->image) {
                Storage::disk('public')->delete($paymentMethod->image);
            }
            $imagePath = $request->file('image')->store('payment_images', 'public');
        } else {
            $imagePath = $paymentMethod->image;  // No cambiar la imagen si no se sube una nueva
        }

        // Actualizar el medio de pago
        $paymentMethod->update([
            'name' => $request->name,
            'campaign' => $request->campaign,
            'url' => $request->url,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('medios-de-pago.index')->with('success', 'Medio de pago actualizado exitosamente.');
    }

    // Eliminar un medio de pago
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Eliminar la imagen asociada si existe
        if ($paymentMethod->image) {
            Storage::disk('public')->delete($paymentMethod->image);
        }

        $paymentMethod->delete();

        return redirect()->route('medios-de-pago.index')->with('success', 'Medio de pago eliminado exitosamente.');
    }
}

