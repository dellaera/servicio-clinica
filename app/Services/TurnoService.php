<?php

namespace App\Services;

use App\Repositories\TurnoRepository;
use Exception;

class TurnoService
{
    protected $turnoRepository;

    public function __construct(TurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function crearTurno(array $datos)
    {
        // Regla de negocio: un paciente no puede tener dos turnos el mismo día a la misma hora
        $turnos = $this->turnoRepository->obtenerTodos();

        $existe = $turnos->first(function ($turno) use ($datos) {
            return $turno->paciente_id == $datos['paciente_id']
                && $turno->fecha == $datos['fecha']
                && $turno->hora == $datos['hora'];
        });

        if ($existe) {
            throw new Exception('El paciente ya tiene un turno asignado en esa fecha y hora.');
        }

        return $this->turnoRepository->crear($datos);
    }

    public function listarTurnos()
    {
        return $this->turnoRepository->obtenerTodos();
    }

    public function eliminarTurno($id)
    {
        return $this->turnoRepository->eliminar($id);
    }
}
