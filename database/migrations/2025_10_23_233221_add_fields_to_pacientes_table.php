<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // Agregamos las columnas nuevas
            $table->string('nombre')->after('id');
            $table->string('apellido')->after('nombre');
            $table->string('dni')->nullable()->unique()->after('apellido');
            $table->date('fecha_nacimiento')->nullable()->after('dni');
            $table->string('telefono')->nullable()->after('fecha_nacimiento');
            $table->string('email')->nullable()->after('telefono');
            $table->string('direccion')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // En down quitamos las columnas (en el orden inverso por seguridad)
            $table->dropColumn(['direccion','email','telefono','fecha_nacimiento','dni','apellido','nombre']);
            // Si la DB crea un índice de unique separado para dni, laravel/dropColumn lo elimina también.
        });
    }
};
