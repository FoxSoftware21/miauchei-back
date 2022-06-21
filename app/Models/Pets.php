<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'especie',
        'sexo',
        'raca',
        'tamanho',
        'cor_predominante',
        'detalhes_fisicos',
        'data_desaparecimento',
        'foto',
        'user_id',
        'status_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function avistamentos()
    {
        return $this->hasMany(Avistamentos::class, 'pet_id');
    }
}
