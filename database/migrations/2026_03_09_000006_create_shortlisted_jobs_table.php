<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shortlisted_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('login_credentials')->onDelete('cascade');
            $table->string('job_title');
            $table->string('company');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->string('job_type')->nullable();
            $table->date('shortlisted_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shortlisted_jobs');
    }
};