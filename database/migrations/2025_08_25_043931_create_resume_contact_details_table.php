<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resume_contact_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('experience_level');
            $table->string('first_name');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
            $table->date('date_of_birth');
            $table->string('nationality')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('license_no')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('language')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->boolean('active_status')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_contact_details');
    }
};
