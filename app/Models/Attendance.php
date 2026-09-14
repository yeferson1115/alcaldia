<?php

namespace App\Models;

// app/Models/AcuerdoCliente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla
    protected $table = 'attendance';

    // Definir la clave primaria
    protected $primaryKey = 'id';

    // Desactivar la auto gestión de las marcas de tiempo (si no usas created_at y updated_at)
    public $timestamps = true;

    // Definir los campos que son asignables
    protected $fillable = [
        'empleoye_id', 
        'type',
        'name',
        'last_name',
        'document',
        'area'
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleoyes::class, 'empleoye_id');
    }
   
}
