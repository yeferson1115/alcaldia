<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Empleoyes extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'empleoyes';

    // Definir la clave primaria
    protected $primaryKey = 'id';

    // Desactivar la auto gestión de las marcas de tiempo (si no usas created_at y updated_at)
    public $timestamps = true;


    protected $fillable = [
        'area_id',
        'role_id',
        'name',
        'last_name',
        'type_document',
        'document',
        'sex',
        'phone',
        'rh',
        'photo',
        'qr',
        'state',
        'city'
    ];

    public function area()
    {
        return $this->belongsTo(Areas::class, 'area_id');
    }

    public function charge()
    {        
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

}

