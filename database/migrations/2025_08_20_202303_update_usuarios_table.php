<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregar campos estándar de Laravel si no existen
            if (!Schema::hasColumn('usuarios', 'name')) {
                $table->string('name')->nullable()->after('nombre_usuario');
            }

            if (!Schema::hasColumn('usuarios', 'email')) {
                $table->string('email')->unique()->nullable()->after('name');
            }

            if (!Schema::hasColumn('usuarios', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            if (!Schema::hasColumn('usuarios', 'password')) {
                $table->string('password')->nullable()->after('email_verified_at');
            }

            if (!Schema::hasColumn('usuarios', 'remember_token')) {
                $table->rememberToken()->after('rol');
            }

            if (!Schema::hasColumn('usuarios', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Eliminar campos agregados (opcional)
            $table->dropColumn([
                'name',
                'email',
                'email_verified_at',
                'password',
                'remember_token',
                'created_at',
                'updated_at'
            ]);
        });
    }
};
