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
        Schema::create('psb_re_register_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_configs_id');
            $table->foreign('psb_configs_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('paid_verification_file')->nullable();
            $table->string('payment_verified_by')->nullable();
            $table->foreign('payment_verified_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('paid_via')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->boolean('is_paid')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_re_register_histories');
    }
};
