<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTurnoRequest;
use App\Http\Requests\UpdateTurnoRequest;
use App\Models\Turno;
use Illuminate\Http\Response;

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
