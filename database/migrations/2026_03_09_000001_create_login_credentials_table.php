<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('login_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_credentials');
    }
};