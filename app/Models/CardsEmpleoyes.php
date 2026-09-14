<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class CardsEmpleoyes extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cards_empleoyes';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'empleoye_id', 'user_id','carnet'
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function empleado()
    {        
        return $this->belongsTo(Empleoyes::class, 'empleoye_id', 'id');
    }
}
