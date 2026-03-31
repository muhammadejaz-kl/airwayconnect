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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('user_id');
            $table->string('username');
            $table->string('plan_id');
            $table->string('validity');
            $table->string('coupon_id')->nullable();
            $table->string('code')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('total_amount');
            $table->string('paid_amount');
            $table->string('payment_status');
            $table->longText('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
