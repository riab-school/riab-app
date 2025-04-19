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
        Schema::create('student_permission_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('requested_by')->nullable();
            $table->foreign('requested_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('checked_out_by')->nullable();
            $table->foreign('checked_out_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('checked_in_by')->nullable();
            $table->foreign('checked_in_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->string('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('reject_reason')->nullable();
            

            $table->string('token')->nullable();
            $table->longText('reason')->nullable();
            $table->longText('pickup_by')->nullable();

            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();

            //Enum Status
            $table->enum('status', ['requested', 'approved', 'check_out', 'check_in', 'rejected', 'canceled'])->default('requested');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_permission_histories');
    }
};
