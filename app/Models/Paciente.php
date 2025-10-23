<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* |----- | Modelo: Paciente |----|
Este modelo representa a los pacientes del consultorio. Cada instancia de esta clase equivale a un registro en la tabla "pacientes" de la base de datos.
Aquí definimos qué campos pueden ser asignados en masa | (fillable) y las relaciones con otros modelos (por ejemplo, Turnos).
En la arquitectura en capas: | - Los modelos están en la capa más cercana a la base de datos.
Son usados por los Repositorios para realizar las consultas.
Campos que se pueden cargar de forma masiva al crear o actualizar un paciente.
protected $fillable = [ 'nombre', 'apellido', 'dni', 'fecha_nacimiento', 'telefono', 'email', 'direccion', ];
Relación uno a muchos: un paciente puede tener varios turnos. public function turnos() { return $this->hasMany(Turno::class); } }*/

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni')->nullable()->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};

//  public function turnos()
{
    return $this->hasMany(Turno::class);
}
