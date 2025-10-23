<?php

namespace App\Repositories;

use App\Models\Paciente;

/*
|--------------------------------------------------------------------------
| Repositorio: PacienteRepository
|--------------------------------------------------------------------------
| Encapsula toda la interacción con la base de datos de pacientes.
| Su rol: ser usado por PacienteService para aislar consultas DB.
*/

class PacienteRepository
{
    public function crear(array $datos)
    {
        return Paciente::create($datos);
    }

    public function obtenerTodos()
    {
        return Paciente::all();
    }

    public function obtenerPorId($id)
    {
        return Paciente::findOrFail($id);
    }

    public function actualizar(Paciente $paciente, array $datos)
    {
        $paciente->update($datos);
        return $paciente;
    }

    public function eliminar(Paciente $paciente)
    {
        return $paciente->delete();
    }
}
