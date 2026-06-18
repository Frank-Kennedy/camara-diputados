<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leyes', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_fr')->nullable();
            $table->string('title_pt')->nullable();
            $table->string('title_en')->nullable();
            $table->string('code')->unique();
            $table->enum('type', ['ley', 'proyecto', 'resolucion', 'decreto']);
            $table->enum('status', ['propuesta', 'en_discusion', 'aprobada', 'rechazada', 'archivada'])->default('propuesta');
            $table->text('summary_es');
            $table->text('summary_fr')->nullable();
            $table->text('summary_pt')->nullable();
            $table->text('summary_en')->nullable();
            $table->longText('content_es')->nullable();
            $table->longText('content_fr')->nullable();
            $table->longText('content_pt')->nullable();
            $table->longText('content_en')->nullable();
            $table->date('presentation_date');
            $table->date('approval_date')->nullable();
            $table->string('file_pdf')->nullable();
            $table->foreignId('diputado_id')->constrained('diputados');
            $table->foreignId('comision_id')->nullable()->constrained('comisiones');
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->boolean('is_public')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leyes');
    }
};
