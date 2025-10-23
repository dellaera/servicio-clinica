<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurnoRequest;
use App\Http\Requests\UpdateTurnoRequest;
use App\Services\TurnoService;
use Illuminate\Http\Response;

/*
|---- Controlador: TurnoController |----|
Este controlador se encarga de recibir las peticiones HTTP relacionadas con los turnos (GET, POST, PUT, DELETE).
Su función principal:
- Recibir la solicitud HTTP.
- Llamar al TurnoService para que gestione la lógica de negocio.
- Devolver la respuesta JSON al cliente.

Buenas prácticas:
- No incluir lógica de negocio aquí; eso se hace en el servicio.
- Validar los datos mediante Form Requests.
*/

class TurnoController extends Controller
{
    protected $turnoService;

    public function __construct(TurnoService $turnoService)
    {
        $this->turnoService = $turnoService;
    }

    // Listar todos los turnos
    public function index()
    {
        return response()->json($this->turnoService->listarTurnos());
    }

    // Crear un nuevo turno
    public function store(StoreTurnoRequest $request)
    {
        $turno = $this->turnoService->crearTurno($request->validated());
        return response()->json($turno, Response::HTTP_CREATED);
    }

    // Mostrar un turno específico
    public function show($id)
    {
        $turno = $this->turnoService->obtenerTurnoPorId($id);
        return response()->json($turno);
    }

    // Actualizar un turno existente
    public function update(UpdateTurnoRequest $request, $id)
    {
        $turno = $this->turnoService->actualizarTurno($id, $request->validated());
        return response()->json($turno);
    }

    // Eliminar un turno
    public function destroy($id)
    {
        $this->turnoService->eliminarTurno($id);
        return response()->json(['mensaje' => 'Turno eliminado correctamente']);
    }
}
