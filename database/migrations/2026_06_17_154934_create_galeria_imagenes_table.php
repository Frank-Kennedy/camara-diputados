<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galeria_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('caption_es')->nullable();
            $table->string('caption_fr')->nullable();
            $table->string('caption_pt')->nullable();
            $table->string('caption_en')->nullable();
            $table->foreignId('noticia_id')->constrained('noticias')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galeria_imagenes');
    }
};