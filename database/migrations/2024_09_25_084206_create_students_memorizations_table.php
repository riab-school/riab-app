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
        Schema::create('students_memorizations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('surah')->nullable();
            $table->integer('from_ayat')->nullable();
            $table->integer('to_ayat')->nullable();
            $table->integer('point_tahsin')->nullable();
            $table->integer('point_tahfidz')->nullable();

            $table->enum('status', ['done', 'not-done'])->default('not-done');

            $table->string('note')->nullable();
            $table->longText('evidence')->nullable();

            $table->string('process_by');
            $table->foreign('process_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_memorizations');
    }
};
