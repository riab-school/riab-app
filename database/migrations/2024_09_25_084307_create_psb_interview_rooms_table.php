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
        Schema::create('psb_interview_rooms', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('psb_config_id');
            $table->foreign('psb_config_id')->references('id')->on('psb_configs')->onUpdate('cascade')->onDelete('cascade');

            $table->date('exam_date');

            $table->string('room_name');
            $table->string('room_session');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psb_interview_rooms');
    }
};
