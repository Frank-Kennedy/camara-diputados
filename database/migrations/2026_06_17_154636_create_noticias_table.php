<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_fr')->nullable();
            $table->string('title_pt')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('summary_es');
            $table->text('summary_fr')->nullable();
            $table->text('summary_pt')->nullable();
            $table->text('summary_en')->nullable();
            $table->longText('content_es');
            $table->longText('content_fr')->nullable();
            $table->longText('content_pt')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('category', ['institucional', 'legislativo', 'eventos', 'comunicados', 'internacional']);
            $table->date('published_date');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->json('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
};