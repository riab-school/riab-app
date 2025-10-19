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
        Schema::create('psb_document_rejections', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_config_id');
            $table->foreign('psb_config_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->string('document_field_key');
            $table->longText('rejection_reason')->nullable();

            $table->string('reject_by');
            $table->foreign('reject_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('status', ['rejected', 'resolved'])->default('rejected');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_document_rejections');
    }
};
