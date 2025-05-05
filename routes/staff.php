<?php

use Illuminate\Support\Facades\Route;

// Middleware
use App\Http\Middleware\EnsureCanAccessMenu;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Staff\MasterStudents\StudentListController;
use App\Http\Controllers\Staff\MasterStudents\StudentStatusController;
use App\Http\Controllers\Staff\MasterStudents\KtsController;

use App\Http\Controllers\Staff\Psb\ConfigController as PsbConfigController;
use App\Http\Controllers\Staff\Psb\DashboardController as PsbDashboardController;
use App\Http\Controllers\Staff\Psb\PaymentController as PsbPaymentController;
use App\Http\Controllers\Staff\Psb\StudentListController as PsbStudentListController;
use App\Http\Controllers\Staff\Psb\InterviewController as PsbInterviewController;
use App\Http\Controllers\Staff\Psb\ExamResultController as PsbExamResultController;
use App\Http\Controllers\Staff\Psb\PrintFormController as PsbPrintFormController;
use App\Http\Controllers\Staff\Psb\PrintReportController as PsbPrintReportController;

use App\Http\Controllers\Staff\Perizinan\DashboardController as PerizinanDashboardController;
use App\Http\Controllers\Staff\Perizinan\ListController as PerizinanListController;
use App\Http\Controllers\Staff\Perizinan\ReportController as PerizinanReportController;

use App\Http\Controllers\Staff\Pelanggaran\DashboardController as PelanggaranDashboardController;
use App\Http\Controllers\Staff\Pelanggaran\ListController as PelanggaranListController;



use App\Http\Controllers\Staff\MasterClassrooms\ClassroomController;

Route::get('/', [HomeController::class, 'homePageStaff'])->name('staff.home');

//Group Middleware
Route::middleware([EnsureCanAccessMenu::class])->group(function() {
    Route::prefix('master-student')->group(function() {
        Route::get('list', [StudentListController::class, 'showListStudentPage'])->name('staff.master-student.list');
        Route::get('list/classrooms', [StudentListController::class, 'getClassRoomsByGrade'])->name('staff.master-student.classrooms');
        Route::get('list/detail', [StudentListController::class, 'studentDetail'])->name('staff.master-student.detail');

        Route::get('status', [StudentStatusController::class, 'showStatusStudentPage'])->name('staff.master-student.status');
        Route::get('status/naik-kelas-from', [StudentStatusController::class, 'dataTableNaikKelasFrom'])->name('staff.master-student.status.naik-kelas-from');


        Route::get('kts', [KtsController::class, 'showKtsPage'])->name('staff.master-student.kts');
        Route::post('kts/detail', [KtsController::class, 'getDetail'])->name('staff.master-student.kts.detail');
        Route::post('kts/save-photo', [KtsController::class, 'saveNewPhoto'])->name('staff.master-student.kts.save-photo');
        Route::post('kts/save-signature', [KtsController::class, 'saveNewSign'])->name('staff.master-student.kts.save-signature');
    });

    Route::prefix('psb')->group(function() {
        Route::prefix('config')->group(function() {
            Route::get('/', [PsbConfigController::class, 'showConfigPage'])->name('staff.master-psb.config');
            Route::get('add', [PsbConfigController::class, 'addNewConfigPage'])->name('staff.master-psb.add-config');
            Route::get('edit', [PsbConfigController::class, 'editConfigPage'])->name('staff.master-psb.edit-config');
            Route::post('update', [PsbConfigController::class, 'handleUpdateConfig'])->name('staff.master-psb.add-config.update');
        });
        Route::get('dashboard', [PsbDashboardController::class, 'showDashboardPage'])->name('staff.master-psb.dashboard');
        Route::get('payment', [PsbPaymentController::class, 'showPaymentPage'])->name('staff.master-psb.payment');
        Route::get('student-list', [PsbStudentListController::class, 'showStudentListPage'])->name('staff.master-psb.student-list');
        
        Route::prefix('interview')->group(function() {
            Route::get('/', [PsbInterviewController::class, 'showInterviewIndex'])->name('staff.master-psb.interview');
            Route::get('bacaan', [PsbInterviewController::class, 'showInterviewBacaan'])->name('staff.master-psb.interview.bacaan');
            Route::get('ibadah', [PsbInterviewController::class, 'showInterviewIbadah'])->name('staff.master-psb.interview.ibadah');
            Route::get('qa', [PsbInterviewController::class, 'showInterviewQA'])->name('staff.master-psb.interview.qa');
            Route::get('parent', [PsbInterviewController::class, 'showInterviewParent'])->name('staff.master-psb.interview.parent');
        });

        Route::prefix('exam-result')->group(function() {
            Route::get('/', [PsbExamResultController::class, 'showExamResultIndex'])->name('staff.master-psb.exam-result');
            Route::get('result', [PsbExamResultController::class, 'showExamResultResult'])->name('staff.master-psb.exam-result.result');
        });
        
        Route::prefix('print-form')->group(function() {
            Route::get('/', [PsbPrintFormController::class, 'showPrintFormIndex'])->name('staff.master-psb.print-form');
            Route::get('result', [PsbPrintFormController::class, 'showPrintFormResult'])->name('staff.master-psb.print-form.result');
        });

        Route::prefix('print-report')->group(function() {
            Route::get('/', [PsbPrintReportController::class, 'showPrintReportIndex'])->name('staff.master-psb.print-report');
            Route::get('result', [PsbPrintReportController::class, 'showPrintReportResult'])->name('staff.master-psb.print-report.result');
        });
        
    });

    Route::prefix('sarpras')->group(function() {
        
    });
    
    Route::prefix('tu')->group(function() {
        
    });
    
    Route::prefix('perizinan')->group(function() {
        Route::get('dashboard', [PerizinanDashboardController::class, 'showDashboard'])->name('staff.perizinan.dashboard');
        Route::prefix('list')->group(function() {
            Route::get('/', [PerizinanListController::class, 'showListPerizinanPage'])->name('staff.perizinan.list');
            Route::get('detail', [PerizinanListController::class, 'showDetailData'])->name('staff.perizinan.detail');
            Route::get('add', [PerizinanListController::class, 'createPagePermission'])->name('staff.perizinan.create');
            Route::post('add', [PerizinanListController::class, 'handleCreatePermission'])->name('staff.perizinan.create');
            Route::get('search', [PerizinanListController::class, 'searchData'])->name('staff.perizinan.search');
            Route::post('status', [PerizinanListController::class, 'handleUpdateStatus'])->name('staff.perizinan.status');
        });
        Route::prefix('laporan')->group(function() {
            Route::get('/', [PerizinanReportController::class, 'showReportFilterPage'])->name('staff.perizinan.laporan');
            Route::post('handleCreateReport', [PerizinanReportController::class, 'handleReportPrint'])->name('staff.perizinan.laporan.handle');
        });
    });

    Route::prefix('pelanggaran')->group(function() {
        Route::get('dashboard', [PelanggaranDashboardController::class, 'showDashboard'])->name('staff.pelanggaran.dashboard');
        Route::prefix('list')->group(function() {
            Route::get('/', [PelanggaranListController::class, 'showListPelanggaranPage'])->name('staff.pelanggaran.list');
            Route::get('detail', [PelanggaranListController::class, 'showDetailData'])->name('staff.pelanggaran.detail');
        });
    });

    Route::prefix('prestasi')->group(function() {
    
    });

    Route::prefix('hafalan-tahfidz')->group(function() {
    
    });

    Route::prefix('kesehatan')->group(function() {
    
    });

    Route::prefix('asrama')->group(function() {
    
    });

    Route::prefix('kelas')->group(function() {
        Route::get('list', [ClassroomController::class, 'showClassroomList'])->name('staff.kelas.list');
    });
});