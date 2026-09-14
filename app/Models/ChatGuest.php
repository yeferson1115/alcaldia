<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGuest  extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id','guest_name'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}


