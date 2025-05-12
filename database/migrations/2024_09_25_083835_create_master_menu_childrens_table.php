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
        Schema::create('master_menu_childrens', function (Blueprint $table) {
            $table->id();
            $table->string('menu_id');
            $table->foreign('menu_id')->references('id')->on('master_menus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('route')->default('#');
            $table->integer('order');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_menu_childrens');
    }
};
