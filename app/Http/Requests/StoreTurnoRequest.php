<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Turno;

/* |----| Form Request: StoreTurnoRequest |----|
Este archivo valida los datos cuando se crea un nuevo turno. Su función es asegurarse de que todos los campos requeridos existan
y tengan el formato correcto antes de intentar guardar el turno. Ejemplo: un paciente debe existir antes de asignarle un turno.
En la arquitectura en capas: Pertenece a la capa de Presentación (junto al controlador). | - Protege la aplicación de datos inválidos o maliciosos.
Define las reglas de validación para crear un turno.*/

class StoreTurnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fecha = $this->input('fecha');
            $hora = $this->input('hora');

            // 🔹 Validar fecha futura
            if ($fecha && now()->gt($fecha)) {
                $validator->errors()->add('fecha', 'No se pueden asignar turnos en fechas pasadas.');
            }

            // 🔹 Validar duplicado
            if ($fecha && $hora) {
                $existe = Turno::where('fecha', $fecha)
                    ->where('hora', $hora)
                    ->exists();

                if ($existe) {
                    $validator->errors()->add('hora', 'Ya existe un turno asignado para esa fecha y hora.');
                }
            }

            // 🔹 Validar franja horaria
            if ($hora) {
                $timestamp = strtotime($hora);
                if ($timestamp < strtotime('08:00') || $timestamp > strtotime('18:00')) {
                    $validator->errors()->add('hora', 'El horario del turno debe estar entre las 08:00 y las 18:00.');
                }
            }
        });
    }
}
