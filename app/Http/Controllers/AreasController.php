<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Areas;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');       
        $this->middleware('permission:Ver Areas', ['only' => ['index',]]);
        $this->middleware('permission:Crear Areas', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Editar Areas', ['only' => ['create', 'store']]);
        $this->middleware('permission:Eliminar Areas', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('admin.areas.index');
       
    }

  
    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'state' => 'required|numeric',
            'can_take_attendance_from_any_dependency' => 'nullable|boolean',
        ]);
    
        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // Código de estado 422 para errores de validación
        }
    
        // Si la validación es exitosa, crear el área
        try {
            Areas::create([
                'name' => $request->name,
                'state' => $request->state,
                'can_take_attendance_from_any_dependency' => $request->boolean('can_take_attendance_from_any_dependency'),
            ]);
    
            // Retornar respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Area Creada Correctamente.',
            ], 200); // Código de estado 200 para éxito
        } catch (\Exception $e) {
            // Manejar errores del sistema
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el área: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }
    }

    public function getAreas(Request $request)
    {
        
            //$data=Maintenance::with('equipo','empresa','repuestos')->orderBy('created_at', 'desc')->get();
            

        $query=Areas::query();


        $data=$query->orderBy('created_at', 'ASC')->get();


        if(auth()->user()->hasPermissionTo('Editar Areas') && auth()->user()->hasPermissionTo('Eliminar Areas')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.url('areas', [$row->id,'edit']).'" class=" mb-1 btn btn-success "><i class="fa-solid fa-pen-to-square"></i></a><div class="form-group"><button   onclick="return elimanar(this)" type="submit" data-token="{{@csrf}}" data-attr="'.url('areas', [$row->id]).'" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="fa-solid fa-trash-can"></i></button></div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        if(auth()->user()->hasPermissionTo('Editar Areas')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.url('areas', [$row->id,'edit']).'" class="mb-1 btn btn-success "><i class="fa-solid fa-pen-to-square"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }elseif(auth()->user()->hasPermissionTo('Eliminar Areas')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<div class="form-group"><button onclick="return elimanar(this)"  type="submit" data-token="{{ csrf_token() }}" data-attr="'.url('areas', [$row->id]).'" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="fa-solid fa-trash-can"></i></button></div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }else{
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
           }
        
    }



    public function edit($id)
    {
        $areas = Areas::findOrFail($id);
        return view('admin.areas.edit', compact('areas'));
    }

    // Actualizar los datos del acuerdo
    public function update(Request $request, $id)
    {
    
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'state' => 'required|numeric',
            'can_take_attendance_from_any_dependency' => 'nullable|boolean',
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // Código de estado 422 para errores de validación
        }

        // Si la validación es exitosa, crear el área
        try {
            $area = Areas::findOrFail($id);
            $area->update([
                'name' => $request->name,
                'state' => $request->state,
                'can_take_attendance_from_any_dependency' => $request->boolean('can_take_attendance_from_any_dependency'),
            ]);

            // Retornar respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Area Actualizada Correctamente.',
            ], 200); // Código de estado 200 para éxito
        } catch (\Exception $e) {
            // Manejar errores del sistema
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el área: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }

    }

    
    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'El ID proporcionado no es válido.',
            ], 400); // Código de estado 400 para error de validación
        }

        try {
            $area = Areas::findOrFail($id);
            $area->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Area eliminada Correctamente.',
            ], 200); // Código de estado 200 para éxito

        } catch (\Exception $e) {
            // Manejar errores del sistema
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el área: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }
    }

}
