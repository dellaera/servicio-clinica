<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'fecha',
        'hora',
        'tipo',
        'notas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
