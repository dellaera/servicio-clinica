<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Modelo: Paciente
|--------------------------------------------------------------------------
| Este modelo representa a los pacientes del consultorio.
| - Responsabilidad: mapear la tabla 'pacientes' en la base de datos.
| - Uso: lo usan repositorios y servicios para leer/guardar datos.
|
| Campos fillable: permiten asignación masiva segura al crear/actualizar.
*/

class Paciente extends Model
{
    use HasFactory;

    // Campos que se pueden llenar en masa (create, update)
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
    ];

    /**
     * Relación: un paciente puede tener muchos turnos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }
}
