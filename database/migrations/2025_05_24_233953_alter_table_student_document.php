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
        Schema::table('students_documents', function (Blueprint $table) {
            $table->longText('report_dayah_4_1')->nullable()->after('report_6_2');
            $table->longText('report_dayah_4_2')->nullable()->after('report_dayah_4_1');
            $table->longText('report_dayah_5_1')->nullable()->after('report_dayah_4_2');
            $table->longText('report_dayah_5_2')->nullable()->after('report_dayah_5_1');
            $table->longText('report_dayah_6_1')->nullable()->after('report_dayah_5_2');
            $table->longText('report_dayah_6_2')->nullable()->after('report_dayah_6_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_documents', function (Blueprint $table) {
            //
        });
    }
};
