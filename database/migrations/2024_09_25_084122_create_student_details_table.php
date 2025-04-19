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
        Schema::create('student_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('name');
            $table->string('nik_ktp')->unique()->nullable();
            $table->string('nik_kk')->nullable();
            $table->string('akte_number')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
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
            $table->string('child_order')->nullable();
            $table->string('from_child_order')->nullable();

            $table->string('hobby')->nullable();
            $table->string('ambition')->nullable();

            $table->boolean('is_biological')->nullable();
            $table->boolean('is_completed')->nullable()->default(false);

            $table->string('generation_id')->nullable();
            $table->foreign('generation_id')->references('id')->on('master_generation_lists')->onUpdate('cascade')->onDelete('SET NULL');

            $table->enum('status', ['active', 'moved', 'drop_out', 'new'])->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
