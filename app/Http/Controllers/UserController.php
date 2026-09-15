<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Log\LogSistema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Areas;


class UserController extends Controller
{
     public function __construct()
    {
        /*$this->middleware('permission:Ver Usuario')->only('index');
        $this->middleware('permission:Registrar Usuario')->only('create');
        $this->middleware('permission:Registrar Usuario')->only('store');
        $this->middleware('permission:Editar Usuario')->only('edit');
        $this->middleware('permission:Editar Usuario')->only('update');
        $this->middleware('permission:Ver Usuario')->only('show');*/

    }

    public function index(Request $request)
    {
        $users = User::with('roles', 'permissions', 'area')
                       ->orderBy('created_at', 'desc')
                       ->get();



        return view('admin.usuarios.index', ['users' => $users]);
    }




    public function create()
    {
        $areas = Areas::where('state', 1)->orderBy('name')->get();

        return view('admin.usuarios.create', compact('areas'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
        ]);

        $user = User::create($request->except('role'));


        if ($request->has('role'))
        {
            $user->assignRole($request->role);
        }

        

        return json_encode(['success' => true, 'user_id' => $user->encode_id]);
    }




    public function show($id)
    {
        $user = User::find($id);
        $areas = Areas::where('state', 1)->orderBy('name')->get();

        return view('admin.usuarios.edit', ['user' => $user, 'areas' => $areas]);
    }




    public function edit($id)
    {
        $user = User::with('roles')->with('permissions')->find($id);
        $areas = Areas::where('state', 1)->orderBy('name')->get();
        

        return view('admin.usuarios.edit', ['user' => $user, 'areas' => $areas]);
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'area_id' => 'required|exists:areas,id',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->area_id = $request->area_id;
        
        
        // Actualizar solo si la contraseña es proporcionada
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($request->has('role'))
        {
            $role = Role::find($request->role);  
            if ($role) {
                $user->syncRoles([$role->name]);  // Pasa el nombre del rol
            }
        }

        return json_encode(['success' => true]);
    }




    public function destroy($id)
    {

        $user = User::find($id)->delete();

        return json_encode(['success' => true]);
    }



    public function autocomplete(Request $request)
    {
        return User::search($request->q)->take(10)->get();
    }
}
