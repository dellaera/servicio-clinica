<?php

namespace App\Repositories;

use App\Models\Turno;

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
