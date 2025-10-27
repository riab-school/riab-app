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
use App\Http\Controllers\Staff\Pelanggaran\ReportController as PelanggaranReportController;

use App\Http\Controllers\Staff\Prestasi\DashboardController as PrestasiDashboardController;
use App\Http\Controllers\Staff\Prestasi\ListController as PrestasiListController;
use App\Http\Controllers\Staff\Prestasi\ReportController as PrestasiReportController;

use App\Http\Controllers\Staff\Kesehatan\DashboardController as KesehatanDashboardController;
use App\Http\Controllers\Staff\Kesehatan\ListController as KesehatanListController;
use App\Http\Controllers\Staff\Kesehatan\ReportController as KesehatanReportController;

use App\Http\Controllers\Staff\MasterClassrooms\ClassroomController as ListClassroomController;

use App\Http\Controllers\Staff\Tahfidz\CreateController as TahfidzCreateController;
use App\Http\Controllers\Staff\Tahfidz\DashboardController as TahfidzDashboardController;
use App\Http\Controllers\Staff\Tahfidz\ListController as TahfidzListController;
use App\Http\Controllers\Staff\Tahfidz\ReportController as TahfidzReportController;

Route::get('/', [HomeController::class, 'homePageStaff'])->name('staff.home');
Route::get('search', [HomeController::class, 'searchList'])->name('staff.search.student');

//Group Middleware
Route::middleware([EnsureCanAccessMenu::class])->group(function() {
    Route::prefix('master-student')->group(function() {
        Route::get('list', [StudentListController::class, 'showListStudentPage'])->name('staff.master-student.list');
        Route::get('list/classrooms', [StudentListController::class, 'getClassRoomsByGrade'])->name('staff.master-student.classrooms');
        Route::get('list/detail', [StudentListController::class, 'studentDetail'])->name('staff.master-student.detail');

        Route::get('status', [StudentStatusController::class, 'showStatusStudentPage'])->name('staff.master-student.status');
        Route::get('status/assign-kelas', [StudentStatusController::class, 'dataTableAssignKelas'])->name('staff.master-student.status.assign-kelas');
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

        Route::prefix('payment')->group(function() {
            Route::get('/', [PsbPaymentController::class, 'showPaymentPage'])->name('staff.master-psb.payment');
            Route::post('handle', [PsbPaymentController::class, 'handleVerification'])->name('staff.master-psb.payment.handle');
        });

        Route::prefix('student-list')->group(function() {
            Route::get('/', [PsbStudentListController::class, 'showStudentListPage'])->name('staff.master-psb.student-list');
            Route::get('/{id}', [PsbStudentListController::class, 'studentDetail'])->name('staff.master-psb.student-detail');
            Route::post('/handle', [PsbStudentListController::class, 'handleAcceptAndRejectData'])->name('staff.master-psb.student-detail.handle');
            Route::post('/handle-seleksi-adm', [PsbStudentListController::class, 'handleKelulusanAdm'])->name('staff.master-psb.student-detail.handle-seleksi-adm');
        });

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
        Route::get('list', function() {
            return view('coming-soon');
        });
        Route::get('status', function() {
            return view('coming-soon');
        });
        Route::get('lapor', function() {
            return view('coming-soon');
        });
    });
    
    Route::prefix('tu')->group(function() {
        Route::get('surat-masuk', function() {
            return view('coming-soon');
        });
        Route::get('surat-keluar', function() {
            return view('coming-soon');
        });
    });
    
    Route::prefix('perizinan')->group(function() {
        Route::get('dashboard', [PerizinanDashboardController::class, 'showDashboard'])->name('staff.perizinan.dashboard');
        Route::prefix('list')->group(function() {
            Route::get('/', [PerizinanListController::class, 'showListPerizinanPage'])->name('staff.perizinan.list');
            Route::get('detail', [PerizinanListController::class, 'showDetailData'])->name('staff.perizinan.detail');
            Route::get('add', [PerizinanListController::class, 'createPagePermission'])->name('staff.perizinan.create');
            Route::post('add', [PerizinanListController::class, 'handleCreatePermission'])->name('staff.perizinan.handle.create');
            Route::get('search', [PerizinanListController::class, 'searchData'])->name('staff.perizinan.search');
            Route::get('search/list', [PerizinanListController::class, 'searchList'])->name('staff.perizinan.search.list');
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
            Route::get('create', [PelanggaranListController::class, 'storeViolationPage'])->name('staff.pelanggaran.create');
            Route::post('create', [PelanggaranListController::class, 'storeViolation'])->name('staff.pelanggaran.handle.create');
            Route::get('search', [PelanggaranListController::class, 'searchData'])->name('staff.pelanggaran.search');
        });
        Route::prefix('laporan')->group(function() {
            Route::get('/', [PelanggaranReportController::class, 'showReportFilterPage'])->name('staff.pelanggaran.laporan');
            Route::post('handleCreateReport', [PelanggaranReportController::class, 'handleReportPrint'])->name('staff.pelanggaran.laporan.handle');
        });
    });

    Route::prefix('prestasi')->group(function() {
        Route::get('dashboard', [PrestasiDashboardController::class, 'showDashboard'])->name('staff.prestasi.dashboard');
        Route::prefix('list')->group(function() {
            Route::get('/', [PrestasiListController::class, 'showListPrestasiPage'])->name('staff.prestasi.list');
            Route::get('detail', [PrestasiListController::class, 'showDetailData'])->name('staff.prestasi.detail');
            Route::get('create', [PrestasiListController::class, 'storeAchievementPage'])->name('staff.prestasi.create');
            Route::post('create', [PrestasiListController::class, 'storeAchievement'])->name('staff.prestasi.handle.create');
            Route::get('search', [PrestasiListController::class, 'searchData'])->name('staff.prestasi.search');
        });
        Route::prefix('laporan')->group(function() {
            Route::get('/', [PrestasiReportController::class, 'showReportFilterPage'])->name('staff.prestasi.laporan');
            Route::post('handleCreateReport', [PrestasiReportController::class, 'handleReportPrint'])->name('staff.prestasi.laporan.handle');
        });
    });

    Route::prefix('hafalan-tahfidz')->group(function() {
        Route::prefix('dashboard')->group(function() {
            Route::get('/', [TahfidzDashboardController::class, 'showDashboard'])->name('staff.tahfidz.dashboard');
            Route::get('card', [TahfidzDashboardController::class, 'cardData'])->name('staff.tahfidz.dashboard.card');
            Route::get('chart1', [TahfidzDashboardController::class, 'getStudentCountPerJuz'])->name('staff.tahfidz.dashboard.chart-1');
        });
        Route::prefix('list')->group(function() {
            Route::get('/', [TahfidzListController::class, 'showListPage'])->name('staff.tahfidz.list');
            Route::get('create', [TahfidzCreateController::class, 'showCreatePage'])->name('staff.tahfidz.list.create');
            Route::post('store', [TahfidzCreateController::class, 'handleStoreTahfidz'])->name('staff.tahfidz.list.create.store');
            Route::get('search', [TahfidzListController::class, 'searchData'])->name('staff.tahfidz.list.serach');
        });
        Route::prefix('wali')->group(function() {
            Route::get('/', function() {
                return view('coming-soon');
            });
        });
        Route::prefix('laporan')->group(function() {
            Route::get('/', [TahfidzReportController::class, 'showReportFilterPage'])->name('staff.tahfidz.laporan');
            Route::post('handleCreateReport', [TahfidzReportController::class, 'handleReportPrint'])->name('staff.tahfidz.laporan.handle');
        });
    });

    Route::prefix('kesehatan')->group(function() {
        Route::get('dashboard', [KesehatanDashboardController::class, 'showDashboard'])->name('staff.kesehatan.dashboard');
        Route::prefix('list')->group(function() {
            Route::get('/', [KesehatanListController::class, 'showListKesehatanPage'])->name('staff.kesehatan.list');
            Route::get('detail', [KesehatanListController::class, 'showDetailData'])->name('staff.kesehatan.detail');
            Route::get('create', [KesehatanListController::class, 'storeDataPage'])->name('staff.kesehatan.create');
            Route::post('create', [KesehatanListController::class, 'handleStoreData'])->name('staff.kesehatan.handle.create');
            Route::get('search', [KesehatanListController::class, 'searchData'])->name('staff.kesehatan.search');
        });
        Route::prefix('laporan')->group(function() {
            Route::get('/', [KesehatanReportController::class, 'showReportFilterPage'])->name('staff.kesehatan.laporan');
            Route::post('handleCreateReport', [KesehatanReportController::class, 'handleReportPrint'])->name('staff.kesehatan.laporan.handle');
        });
    });

    Route::prefix('asrama')->group(function() {
        Route::get('list', function() {
            return view('coming-soon');
        });
        Route::get('laporan', function() {
            return view('coming-soon');
        });
    });

    Route::prefix('kelas')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/', [ListClassroomController::class, 'showClassroomList'])->name('staff.kelas.list');
            Route::get('create', [ListClassroomController::class, 'showCreatePage'])->name('staff.kelas.create');
            Route::post('create', [ListClassroomController::class, 'handleCreate'])->name('staff.kelas.create.handle');
        });
        Route::get('laporan', function() {
            return view('coming-soon');
        });
    });
});