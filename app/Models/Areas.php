<?php

namespace App\Models;

// app/Models/AcuerdoCliente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla
    protected $table = 'areas';

    // Definir la clave primaria
    protected $primaryKey = 'id';

    // Desactivar la auto gestión de las marcas de tiempo (si no usas created_at y updated_at)
    public $timestamps = true;

    // Definir los campos que son asignables
    protected $fillable = [
        'name', 
        'state',
        'can_take_attendance_from_any_dependency',
    ];

    protected $casts = [
        'can_take_attendance_from_any_dependency' => 'boolean',
    ];

   
}
