<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::orderBy('id', 'desc')->paginate(10);
        return response()->json($pacientes);
    }

    public function store(PacienteRequest $request)
    {
        $paciente = Paciente::create($request->validated());
        return response()->json($paciente, 201);
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    public function update(PacienteRequest $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->validated());
        return response()->json($paciente);
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['mensaje' => 'Paciente eliminado correctamente']);
    }
}
