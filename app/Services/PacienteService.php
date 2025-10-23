<?php

namespace App\Services;

use App\Repositories\PacienteRepository;
use App\Models\Paciente;

/*
|--------------------------------------------------------------------------
| Servicio: PacienteService
|--------------------------------------------------------------------------
| Contiene la lógica de negocio de los pacientes.
| Recibe solicitudes desde el controlador y llama al repositorio.
| Ventaja: mantiene el controlador limpio y centraliza reglas de negocio.
*/

class PacienteService
{
    protected $pacienteRepository;

    public function __construct(PacienteRepository $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function crearPaciente(array $datos)
    {
        // Aquí podrías agregar reglas de negocio, ej: validar duplicados
        return $this->pacienteRepository->crear($datos);
    }

    public function listarPacientes()
    {
        return $this->pacienteRepository->obtenerTodos();
    }

    public function obtenerPacientePorId($id)
    {
        return $this->pacienteRepository->obtenerPorId($id);
    }

    public function actualizarPaciente(Paciente $paciente, array $datos)
    {
        return $this->pacienteRepository->actualizar($paciente, $datos);
    }

    public function eliminarPaciente(Paciente $paciente)
    {
        return $this->pacienteRepository->eliminar($paciente);
    }
}
