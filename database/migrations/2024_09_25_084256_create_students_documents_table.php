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
        Schema::create('students_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->longText('photo')->nullable();

            $table->longText('ktp_file')->nullable();
            $table->longText('kk_file')->nullable();
            $table->longText('akte_file')->nullable();
            $table->longText('nisn_file')->nullable();
            $table->longText('nis_file')->nullable();
            $table->longText('dad_ktp_file')->nullable();
            $table->longText('mom_ktp_file')->nullable();
            $table->longText('guardian_ktp_file')->nullable();

            $table->longText('rank_certificate')->nullable();
            $table->string('origin_head_recommendation')->nullable();
            $table->longText('certificate_of_letter')->nullable();
            $table->longText('letter_of_promise_to_financing')->nullable();

            $table->longText('report_1_1')->nullable();
            $table->longText('report_1_2')->nullable();
            $table->longText('report_2_1')->nullable();
            $table->longText('report_2_2')->nullable();
            $table->longText('report_3_1')->nullable();
            $table->longText('report_3_2')->nullable();
            $table->longText('report_4_1')->nullable();
            $table->longText('report_4_2')->nullable();
            $table->longText('report_5_1')->nullable();
            $table->longText('report_5_2')->nullable();
            $table->longText('report_6_1')->nullable();
            $table->longText('report_6_2')->nullable();

            $table->longText('bpjs')->nullable();
            $table->longText('kis')->nullable();
            $table->longText('kip')->nullable();
            $table->longText('certificate_of_health')->nullable();
            $table->longText('vaccine_certificate_1')->nullable();
            $table->longText('vaccine_certificate_2')->nullable();
            $table->longText('vaccine_certificate_3')->nullable();

            $table->longText('statement_letter_of_not_changing_majors')->nullable();

            $table->boolean('is_completed')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_documents');
    }
};
