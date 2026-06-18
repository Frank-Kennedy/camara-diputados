<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transparencia', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_fr')->nullable();
            $table->string('title_pt')->nullable();
            $table->string('title_en')->nullable();
            $table->enum('category', ['presupuesto', 'informe_gestion', 'rendicion_cuentas', 'contrataciones', 'planificacion']);
            $table->year('year');
            $table->string('file_pdf')->nullable();
            $table->string('file_excel')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_pt')->nullable();
            $table->text('description_en')->nullable();
            $table->date('publication_date');
            $table->boolean('is_public')->default(true);
            $table->integer('downloads')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transparencia');
    }
};
