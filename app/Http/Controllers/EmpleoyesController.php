<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleoyes;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Areas;
use Spatie\Permission\Models\Role;
use App\Imports\EmpleoyesImport;
use Maatwebsite\Excel\Facades\Excel;



class EmpleoyesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
        $this->middleware('permission:Ver Personal', ['only' => ['index',]]);
        $this->middleware('permission:Crear Personal', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Editar Personal', ['only' => ['create', 'store']]);
        $this->middleware('permission:Eliminar Personal', ['only' => ['destroy']]);
    }
    public function index()
    {
        //$empleoyes = Empleoyes::with('area','charge')->get();
        return view ('admin.empleoyes.index');
    }

    public function getEmpleoyes()
    {
        
       
        $query=Empleoyes::query();


        $data=$query->with('area','charge')->orderBy('created_at', 'ASC')->get();


        if(auth()->user()->hasPermissionTo('Editar Personal') && auth()->user()->hasPermissionTo('Eliminar Personal')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.url('empleados', [$row->id,'edit']).'" class=" mb-1 btn btn-success "><i class="fa-solid fa-pen-to-square"></i></a><div class="form-group"><button   onclick="return elimanar(this)" type="submit" data-token="{{@csrf}}" data-attr="'.url('empleados', [$row->id]).'" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="fa-solid fa-trash-can"></i></button></div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        if(auth()->user()->hasPermissionTo('Editar Personal')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="'.url('empleados', [$row->id,'edit']).'" class="mb-1 btn btn-success "><i class="fa-solid fa-pen-to-square"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }elseif(auth()->user()->hasPermissionTo('Eliminar Personal')){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<div class="form-group"><button onclick="return elimanar(this)"  type="submit" data-token="{{ csrf_token() }}" data-attr="'.url('empleados', [$row->id]).'" class="btn btn-danger waves-effect waves-float waves-light delete-user" value="Delete user"><i class="fa-solid fa-trash-can"></i></button></div>';
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $areas = Areas::get();        
        $charges = Role::where('name','<>','Admin')->get();
        return view ('admin.empleoyes.create',compact('charges','areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          // Validación de los datos
          $validator = Validator::make($request->all(), [
            'area_id' => 'required|exists:areas,id',
            'role_id' => 'required|exists:roles,id', 
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document' => 'required|string|unique:empleoyes,document', 
            'state' => 'required|string|max:50', 
            'sex' => 'nullable|required|string',                
            'rh' => 'nullable|string|max:5',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Foto opcional
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
            $imageName = null;
            if ($request->hasFile('photo')) {
                $imageName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('images/empleoyes'), $imageName);
            }
        
            // Crear el registro en la base de datos
            $student = Empleoyes::create([
                'area_id' => $request->area_id,
                'role_id' => $request->role_id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'type_document' => $request->type_document,
                'document' => $request->document,
                'sex' => $request->sex,
                'photo' => $imageName,
                'phone' => $request->phone,
                'rh' => $request->rh,
                'state' => $request->state,
                'city' => $request->city,
            ]);
            // Retornar respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Empleado Creado Correctamente.',
            ], 200); // Código de estado 200 para éxito
        } catch (\Exception $e) {
            // Manejar errores del sistema
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el empleado: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }


          
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $empleoye = Empleoyes::with('area','charge')->findOrFail($id);
        $areas = Areas::get();        
        $charges = Role::where('name','<>','Admin')->get();
        return view('admin.empleoyes.edit', ['empleoye' => $empleoye,'areas'=>$areas,'charges'=>$charges]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleoyes  $empleoyes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validación de los datos
            $validator = Validator::make($request->all(), [
                'area_id' => 'required|exists:areas,id',
                'role_id' => 'required|exists:roles,id', 
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'state' => 'required|string|max:50', 
                'document' => 'required|unique:empleoyes,document,' . $id, // Excluyendo el ID actual
                'sex' => 'nullable|required|string',                
                'rh' => 'nullable|string|max:5',
                'phone' => 'nullable|string|max:20',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Foto opcional
            ]);
    
            // Si la validación falla, devolver los errores en formato JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity
            }
    
            // Buscar el empleado por ID
            $empleoye = Empleoyes::findOrFail($id);
    
            // Si hay una nueva foto, manejamos la carga y eliminación de la foto anterior
            if ($request->file('photo')) {
                $imageName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('images/empleoyes'), $imageName);
    
                // Eliminar la foto anterior si existe
                $image_path = public_path() . '/images/empleoyes/' . $empleoye->photo;
                if (@getimagesize($image_path)) {
                    unlink($image_path);
                }
    
                // Actualizamos el nombre de la foto en el registro
                $empleoye->photo = $imageName;
            }
    
            // Actualizar otros campos del empleado
            $empleoye->area_id = $request->area_id;
            $empleoye->role_id = $request->role_id;
            $empleoye->name = $request->name;
            $empleoye->last_name = $request->last_name;
            $empleoye->type_document = $request->type_document;
            $empleoye->document = $request->document;
            $empleoye->sex = $request->sex;           
            $empleoye->phone = $request->phone;
            $empleoye->rh = $request->rh;
            $empleoye->state = $request->state;
            $empleoye->city = $request->city;
    
            // Guardar los cambios en la base de datos
            $empleoye->save();
    
            // Retornar respuesta de éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Empleado actualizado correctamente.',
            ], 200); // Código de estado 200 para éxito
    
        } catch (\Exception $e) {
            // Manejo de errores del sistema
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el empleado: ' . $e->getMessage(),
            ], 500); // Código de estado 500 para errores del servidor
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
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
            
            $empleoye = Empleoyes::findOrFail($id);
            $image_path = public_path().'/images/empleoyes/'.$empleoye->photo;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $empleoye->delete();
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




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $areas = Areas::get();        
        $charges = Role::where('name','<>','Admin')->get();
        return view ('admin.empleoyes.import',compact('areas','charges'));
    }
    public function importdata(Request $request)
    {
        try {
            // Validación del archivo recibido
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv',  // Validar si es un archivo Excel o CSV
            ]);
    
            // Asegúrate de que el archivo esté presente en la solicitud
            if ($request->hasFile('file')) {
                // Importar el archivo Excel
                Excel::import(new EmpleoyesImport, $request->file('file'));
    
                // Respuesta de éxito si todo va bien
                return response()->json([
                    'status' => 'success',
                    'message' => 'Empleados importados exitosamente.',
                ], 200);
            } else {
                // Respuesta si el archivo no fue proporcionado
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se ha recibido un archivo para importar.',
                ], 400);
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Capturar errores de validación de Excel, si hay datos inválidos en el archivo
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación del archivo: ' . $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            // Capturar cualquier otro error general
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar el archivo: ' . $e->getMessage(),
            ], 500);
        }
    }

  
}
