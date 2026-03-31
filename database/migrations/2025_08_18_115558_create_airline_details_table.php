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
        Schema::create('airline_details', function (Blueprint $table) {
            $table->id();
 
            $table->unsignedBigInteger('airline_id');
            $table->string('part');
            $table->enum('airlines_type', ['Cargo', 'Passenger', 'Combi']);
            $table->enum('job_type', ['PartTime', 'FullTime', 'Remote']);
            $table->string('schedule_type');
            $table->enum('option_401k', ['Yes', 'No']);
            $table->enum('flight_benefits', ['Yes', 'No']);
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('airline_id')->references('id')->on('airline_directories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_details');
    }
};
