<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* |----| Modelo: Turno |---|
Este modelo representa un turno médico en el sistema.
Contiene información como el paciente asociado, fecha, hora, tipo de turno y notas adicionales.
En la arquitectura en capas: Este modelo es la base de la capa de datos. Es manipulado por los repositorios para acceder a la base de datos.
Campos que pueden ser asignados en masa al crear o actualizar un turno. protected $fillable = [ 'paciente_id', 'fecha', 'hora', 'tipo', 'notas', ];
Relación: cada turno pertenece a un paciente. public function paciente() { return $this->belongsTo(Paciente::class); } }*/

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
