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
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
             
            $table->unsignedBigInteger('user_id');
            $table->json('topic_ids')->nullable(); 
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('banner')->nullable();
            $table->boolean('status')->default(1);
            $table->json('restricted_ids')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
