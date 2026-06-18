<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diputado_comision', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diputado_id')
                  ->constrained('diputados')
                  ->onDelete('cascade');
            $table->foreignId('comision_id')
                  ->constrained('comisiones')
                  ->onDelete('cascade');
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diputado_comision');
    }
};