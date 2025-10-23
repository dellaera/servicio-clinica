<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::with('paciente')->orderBy('fecha', 'desc')->paginate(10);
        return response()->json($turnos);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $turno = Turno::create($datos);
        return response()->json($turno, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $turno = Turno::with('paciente')->findOrFail($id);
        return response()->json($turno);
    }

    public function update(Request $request, $id)
    {
        $turno = Turno::findOrFail($id);

        $datos = $request->validate([
            'paciente_id' => 'sometimes|required|exists:pacientes,id',
            'fecha' => 'sometimes|required|date',
            'hora' => 'sometimes|required',
            'tipo' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ]);

        $turno->update($datos);
        return response()->json($turno);
    }

    public function destroy($id)
    {
        $turno = Turno::findOrFail($id);
        $turno->delete();

        return response()->json(['mensaje' => 'Turno eliminado correctamente']);
    }
}
