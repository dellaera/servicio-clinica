<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PacienteRequest;
use App\Services\PacienteService;
use App\Models\Paciente;
use Illuminate\Http\Response;

/*
|---- Controlador: PacienteController |----|
Este controlador gestiona las solicitudes HTTP relacionadas con pacientes (GET, POST, PUT, DELETE).
Funciones:
- Recibir la solicitud HTTP.
- Llamar al PacienteService para aplicar la lógica de negocio.
- Retornar la respuesta JSON al cliente.

Buenas prácticas:
- No incluir lógica de negocio aquí; todo va al service.
- Validar los datos mediante Form Requests.
*/

class PacienteController extends Controller
{
    protected $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    // Listar todos los pacientes
    public function index()
    {
        return response()->json($this->pacienteService->listarPacientes());
    }

    // Crear un nuevo paciente
    public function store(PacienteRequest $request)
    {
        $paciente = $this->pacienteService->crearPaciente($request->validated());
        return response()->json($paciente, Response::HTTP_CREATED);
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        $paciente = $this->pacienteService->obtenerPacientePorId($id);
        return response()->json($paciente);
    }

    // Actualizar un paciente existente
    public function update(PacienteRequest $request, $id)
    {
        $paciente = $this->pacienteService->obtenerPacientePorId($id);
        $pacienteActualizado = $this->pacienteService->actualizarPaciente($paciente, $request->validated());
        return response()->json($pacienteActualizado);
    }

    // Eliminar un paciente
    public function destroy($id)
    {
        $paciente = $this->pacienteService->obtenerPacientePorId($id);
        $this->pacienteService->eliminarPaciente($paciente);

        return response()->json(['mensaje' => 'Paciente eliminado correctamente']);
    }
}
