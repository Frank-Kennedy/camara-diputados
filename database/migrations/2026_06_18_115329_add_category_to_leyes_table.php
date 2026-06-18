<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leyes', function (Blueprint $table) {
            // Agregar columna category
            if (!Schema::hasColumn('leyes', 'category')) {
                $table->enum('category', ['civil', 'penal', 'laboral', 'administrativo', 'constitucional', 'otros'])
                    ->nullable()
                    ->after('code');
            }
            
            // Agregar columna is_featured si no existe
            if (!Schema::hasColumn('leyes', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_public');
            }
        });
    }

    public function down()
    {
        Schema::table('leyes', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('is_featured');
        });
    }
};
