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
        Schema::create('students_parent_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('dad_name')->nullable();
            $table->string('dad_nik_ktp')->nullable();
            $table->string('dad_phone')->nullable();
            $table->string('dad_latest_education')->nullable();
            $table->string('dad_occupation')->nullable();
            $table->string('dad_income')->nullable();

            $table->enum('dad_country', ['idn', 'others'])->nullable();
            $table->string('dad_address')->nullable();
            $table->unsignedBigInteger('dad_province_id')->nullable();
            $table->foreign('dad_province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('dad_city_id')->nullable();
            $table->foreign('dad_city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('dad_district_id')->nullable();
            $table->foreign('dad_district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('dad_village_id')->nullable();
            $table->foreign('dad_village_id')->references('id')->on('villages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('dad_postal_code')->nullable();
            $table->boolean('dad_is_alive')->nullable();

            $table->string('mom_name')->nullable();
            $table->string('mom_nik_ktp')->nullable();
            $table->string('mom_phone')->nullable();
            $table->string('mom_latest_education')->nullable();
            $table->string('mom_occupation')->nullable();
            $table->string('mom_income')->nullable();

            $table->enum('mom_country', ['idn', 'others'])->nullable();
            $table->string('mom_address')->nullable();
            $table->unsignedBigInteger('mom_province_id')->nullable();
            $table->foreign('mom_province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('mom_city_id')->nullable();
            $table->foreign('mom_city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('mom_district_id')->nullable();
            $table->foreign('mom_district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('mom_village_id')->nullable();
            $table->foreign('mom_village_id')->references('id')->on('villages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mom_postal_code')->nullable();
            $table->boolean('mom_is_alive')->nullable();

            $table->enum('marital_status', ['married', 'divorce', 'dead-divorce',])->nullable();

            $table->boolean('is_completed')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_parent_details');
    }
};
