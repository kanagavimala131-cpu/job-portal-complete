<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('login_credentials')->onDelete('cascade');
            $table->string('job_title');
            $table->string('company');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->string('status')->default('Applied');
            $table->date('applied_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applied_jobs');
    }
};