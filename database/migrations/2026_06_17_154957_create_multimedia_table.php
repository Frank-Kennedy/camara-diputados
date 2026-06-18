<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_fr')->nullable();
            $table->string('title_pt')->nullable();
            $table->string('title_en')->nullable();
            $table->enum('type', ['video', 'audio', 'live_stream']);
            $table->string('url');
            $table->string('embed_code')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_pt')->nullable();
            $table->text('description_en')->nullable();
            $table->date('recorded_date');
            $table->boolean('is_live')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multimedia');
    }
};
