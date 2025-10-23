<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Turno;

/* |----| Form Request: UpdateTurnoRequest |----|
Este archivo valida los datos cuando se actualiza un turno existente. A diferencia del StoreTurnoRequest, los campos no son todos obligatorios;
solo se validan los que vienen en la petición. Esto permite modificar parcialmente un turno (por ejemplo, solo la fecha o la hora).*/

class UpdateTurnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paciente_id' => 'sometimes|required|exists:pacientes,id',
            'fecha' => 'sometimes|required|date',
            'hora' => 'sometimes|required',
            'tipo' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fecha = $this->input('fecha');
            $hora = $this->input('hora');
            $id = $this->route('id'); // el id del turno a actualizar

            if ($fecha && now()->gt($fecha)) {
                $validator->errors()->add('fecha', 'No se pueden asignar turnos en fechas pasadas.');
            }

            if ($fecha && $hora) {
                $existe = Turno::where('fecha', $fecha)
                    ->where('hora', $hora)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($existe) {
                    $validator->errors()->add('hora', 'Ya existe un turno asignado para esa fecha y hora.');
                }
            }

            if ($hora) {
                $timestamp = strtotime($hora);
                if ($timestamp < strtotime('08:00') || $timestamp > strtotime('18:00')) {
                    $validator->errors()->add('hora', 'El horario del turno debe estar entre las 08:00 y las 18:00.');
                }
            }
        });
    }
}
