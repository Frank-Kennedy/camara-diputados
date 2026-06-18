<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('institutional_info', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('title_es');
            $table->string('title_fr')->nullable();
            $table->string('title_pt')->nullable();
            $table->string('title_en')->nullable();
            $table->longText('content_es');
            $table->longText('content_fr')->nullable();
            $table->longText('content_pt')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('institutional_info');
    }
};
