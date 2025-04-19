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
        Schema::create('students_guardian_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('phone')->nullable();

            $table->enum('country', ['idn', 'others'])->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('village_id')->nullable();
            $table->foreign('village_id')->references('id')->on('villages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('postal_code')->nullable();

            $table->string('relation_detail')->nullable();

            $table->boolean('is_completed')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_guardian_details');
    }
};
