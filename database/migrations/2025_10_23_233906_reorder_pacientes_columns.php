<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Renombramos tabla original
        if (Schema::hasTable('pacientes')) {
            Schema::rename('pacientes', 'pacientes_old');
        }

        // 2️⃣ Crear tabla nueva con columnas en el orden deseado
        DB::statement("
            CREATE TABLE pacientes (
                id BIGSERIAL PRIMARY KEY,
                nombre VARCHAR(255) NOT NULL,
                apellido VARCHAR(255) NOT NULL,
                dni VARCHAR(255) UNIQUE,
                fecha_nacimiento DATE,
                telefono VARCHAR(255),
                email VARCHAR(255),
                direccion VARCHAR(255),
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )
        ");

        // 3️⃣ Copiar datos desde la tabla vieja
        if (Schema::hasTable('pacientes_old')) {
            DB::statement("
                INSERT INTO pacientes (id, nombre, apellido, dni, fecha_nacimiento, telefono, email, direccion, created_at, updated_at)
                SELECT id, nombre, apellido, dni, fecha_nacimiento, telefono, email, direccion, created_at, updated_at
                FROM pacientes_old
            ");
        }

        // 4️⃣ Actualizar foreign keys en otras tablas (ejemplo con turnos)
        if (Schema::hasTable('turnos')) {
            DB::statement("
                ALTER TABLE turnos
                DROP CONSTRAINT IF EXISTS turnos_paciente_id_foreign,
                ADD CONSTRAINT turnos_paciente_id_foreign
                FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
            ");
        }

        // 5️⃣ Eliminar la tabla vieja
        if (Schema::hasTable('pacientes_old')) {
            Schema::drop('pacientes_old');
        }
    }

    public function down(): void
    {
        // No reversible automáticamente
    }
};
