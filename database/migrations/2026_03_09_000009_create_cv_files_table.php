<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cv_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('login_credentials')->onDelete('cascade');
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path');
            $table->integer('file_size');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cv_files');
    }
};