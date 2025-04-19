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
        Schema::create('students_healths', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('blood', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable()->default(null);

            $table->longText('food_alergic')->nullable();
            $table->longText('drug_alergic')->nullable();
            $table->longText('other_alergic')->nullable();

            $table->longText('disease_history')->nullable();
            $table->longText('disease_ongoing')->nullable();

            $table->longText('drug_consumption')->nullable();

            $table->string('weight')->nullable();
            $table->string('height')->nullable();

            $table->boolean('is_completed')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_healths');
    }
};
