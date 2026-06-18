<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultas_ciudadanas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject_es');
            $table->string('subject_fr')->nullable();
            $table->string('subject_pt')->nullable();
            $table->string('subject_en')->nullable();
            $table->enum('type', ['sugerencia', 'consulta', 'queja', 'solicitud', 'denuncia']);
            $table->text('message_es');
            $table->text('message_fr')->nullable();
            $table->text('message_pt')->nullable();
            $table->text('message_en')->nullable();
            $table->string('file_attachment')->nullable();
            $table->enum('status', ['pendiente', 'en_proceso', 'resuelta', 'archivada'])->default('pendiente');
            $table->text('response_es')->nullable();
            $table->text('response_fr')->nullable();
            $table->text('response_pt')->nullable();
            $table->text('response_en')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->date('response_date')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_anonymous')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas_ciudadanas');
    }
};