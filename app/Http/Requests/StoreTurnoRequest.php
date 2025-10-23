<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Turno;

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
