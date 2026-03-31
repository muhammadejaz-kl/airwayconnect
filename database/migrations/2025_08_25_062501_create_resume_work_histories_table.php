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
        Schema::create('resume_work_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('count')->default(1);
            $table->string('job_title');
            $table->string('employer');
            $table->string('location');
            $table->boolean('remote')->default(0);
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->boolean('currently_work')->default(0);
            $table->string('experienced_with')->nullable();
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
        Schema::dropIfExists('resume_work_histories');
    }
};
