<?php

namespace App\Repositories;

use App\Models\Turno;

/* |---- | Repositorio: TurnoRepository |----|
Este repositorio encapsula toda la interacción con la base de datos relacionada con los turnos.
Su rol en la arquitectura en capas:- Aislar la lógica de consultas a la base de datos del resto de la aplicación.
- Ser utilizado por el TurnoService para obtener, crear, actualizar o eliminar turnos.
Ventaja: Si cambiamos la base de datos o el ORM, solo se modifican los repositorios.
crear($datos) → Crea un nuevo turno en la base de datos.
obtenerTodos() → Devuelve todos los turnos con datos del paciente.
obtenerPorId($id) → Devuelve un turno específico con datos del paciente.
eliminar($id) → Elimina un turno por ID.*/

class TurnoRepository
{
    public function crear(array $datos)
    {
        return Turno::create($datos);
    }

    public function obtenerTodos()
    {
        return Turno::with('paciente')->get();
    }

    public function obtenerPorId($id)
    {
        return Turno::with('paciente')->findOrFail($id);
    }

    public function eliminar($id)
    {
        $turno = Turno::findOrFail($id);
        return $turno->delete();
    }
}
