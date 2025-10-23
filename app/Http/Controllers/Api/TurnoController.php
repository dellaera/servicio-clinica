<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurnoRequest;
use App\Http\Requests\UpdateTurnoRequest;
use App\Models\Turno;
use Illuminate\Http\Response;

/* |---- Controlador: TurnoController |----|
Este controlador se encarga de recibir las peticiones HTTP relacionadas con los turnos (GET, POST, PUT, DELETE).
Su rol principal en la arquitectura en capas: - Recibe la solicitud. - Llama al servicio correspondiente
(en este caso, aún llamamos al modelo directamente, pero más adelante lo refactorizaremos para usar TurnoService y TurnoRepository).
- Devuelve la respuesta JSON al cliente. Buenas prácticas:- No incluir lógica de negocio aquí; eso debe ir en los servicios.
- Validar datos mediante Form Requests antes de procesarlos.
index() → Muestra lista paginada de turnos con datos del paciente.
store() → Crea un nuevo turno con los datos validados.
show($id) → Muestra un turno específico con datos del paciente.
update($request, $id) → Actualiza un turno existente con datos validados.
destroy($id) → Elimina un turno por ID.*/

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::with('paciente')->orderBy('fecha', 'desc')->paginate(10);
        return response()->json($turnos);
    }

    public function store(StoreTurnoRequest $request)
    {
        $turno = Turno::create($request->validated());
        return response()->json($turno, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $turno = Turno::with('paciente')->findOrFail($id);
        return response()->json($turno);
    }

    public function update(UpdateTurnoRequest $request, $id)
    {
        $turno = Turno::findOrFail($id);
        $turno->update($request->validated());
        return response()->json($turno);
    }

    public function destroy($id)
    {
        $turno = Turno::findOrFail($id);
        $turno->delete();

        return response()->json(['mensaje' => 'Turno eliminado correctamente']);
    }
}
