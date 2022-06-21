<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avistamentos extends Model
{
    use HasFactory;

    protected $table = 'avistamentos';

    protected $fillable = [
        'ultima_vez_visto',
        'data_avistamento',
        'user_id',
        'pet_id',
        'esta_com_pet'
    ];

    public function pets()
    {
        return $this->belongsTo(Pets::class);
    }
}
