<?php

namespace App\Services;

use App\Repositories\TurnoRepository;
use Exception;

/* |----| Servicio: TurnoService |----|
Este servicio contiene la lógica de negocio de los turnos. Por ejemplo: verificar reglas antes de crear o actualizar un turno.
Su rol en la arquitectura en capas: Recibe solicitudes desde el controlador. - Llama al repositorio para interactuar con la base de datos.
- Puede aplicar reglas de negocio (validaciones extra, notificaciones, etc.) | | Ventaja: | - Mantiene el controlador limpio y enfocado en la interacción HTTP.
listarTurnos($cantidad) → Devuelve todos los turnos paginados.
crearTurno($datos) → Crea un turno aplicando reglas de negocio (no duplicados por paciente, fecha y hora).
obtenerTurnoPorId($id) → Busca un turno por ID.
actualizarTurno($turno, $datos) → Actualiza un turno existente.
eliminarTurno($turno) → Elimina un turno*/

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
