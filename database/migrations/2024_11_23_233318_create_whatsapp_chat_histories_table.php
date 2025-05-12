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
        Schema::create('whatsapp_chat_histories', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['text', 'image', 'video', 'audio', 'document']);

            $table->string('category')->nullable();

            $table->string('media_url')->nullable();
            $table->string('media_mime')->nullable();

            $table->string('name')->nullable();
            $table->string('phone');
            $table->longText('message')->collation('utf8mb4_unicode_ci');

            $table->string('response_id')->nullable();
            $table->string('response_status')->nullable();
            $table->string('response_message')->nullable();

            $table->enum('process_status', ['pending', 'success', 'failed'])->nullable()->default('pending');
            $table->boolean('is_read')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_chat_histories');
    }
};
