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
        Schema::create('psb_payment_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_config_id');
            $table->foreign('psb_config_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('payment_method', ['qris', 'payment-gateway', 'manual', 'others']);
            $table->longText('evidence')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('amount')->nullable();
            $table->dateTime('request_at')->nullable();

            $table->longText('qris_content')->nullable();
            $table->string('qris_invoiceid')->nullable();
            $table->string('qris_nmid')->nullable();
            
            $table->string('manual_bank_from')->nullable();
            $table->string('manual_invoiceid')->nullable();
            
            $table->enum('payment_status', ['paid', 'unpaid', 'pending'])->default('pending');
            $table->enum('status', ['success', 'failed'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_payment_histories');
    }
};
