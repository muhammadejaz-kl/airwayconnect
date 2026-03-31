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
        Schema::create('interview_question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->enum('type', ['QA', 'MSQ'])->default('QA');
            $table->longText('question');
            $table->json('options')->nullable();
            $table->longText('answer');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('topic_id')->references('id')->on('interview_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_question_answers');
    }
};
