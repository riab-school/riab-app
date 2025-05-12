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
        Schema::create('user_has_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('menu_children_id')->constrained('master_menu_childrens')->onUpdate('cascade')->onDelete('cascade');

            $table->dateTime('assigned_at');
            $table->boolean('is_permanent_access')->default(1);
            $table->dateTime('permited_start_at')->nullable();
            $table->dateTime('permited_end_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_menu_permissions');
    }
};
