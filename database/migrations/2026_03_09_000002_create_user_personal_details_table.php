<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('user_personal_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('login_credentials')->onDelete('cascade');
        $table->string('fullname');
        $table->date('date_of_birth')->default('2000-01-01'); // 👈 ADD DEFAULT
        $table->enum('gender', ['male', 'female', 'transgender'])->default('female'); // 👈 ADD DEFAULT
        $table->enum('work_status', ['fresher', 'experience'])->default('experience'); // 👈 ADD DEFAULT
        $table->integer('total_experience_years')->default(0);
        $table->integer('total_experience_months')->default(0);
        $table->decimal('current_salary', 10, 2)->default(0); // 👈 ADD DEFAULT
        $table->string('notice_period')->default('Notice Required'); // 👈 ADD DEFAULT
        $table->string('phone', 10)->default('0000000000'); // 👈 ADD DEFAULT
        $table->string('email');
        $table->string('profile_photo')->nullable();
        $table->integer('skills_percentage')->default(85);
        $table->string('facebook_url')->nullable();
        $table->string('twitter_url')->nullable();
        $table->string('linkedin_url')->nullable();
        $table->string('current_city')->default('City'); // 👈 ADD DEFAULT
        $table->string('current_area')->default('Area'); // 👈 ADD DEFAULT
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('user_personal_details');
    }
};