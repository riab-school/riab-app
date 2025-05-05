<?php

use App\Http\Controllers\Admin\AppConfigsController;
use App\Http\Controllers\Admin\AppLogsController;
use App\Http\Controllers\Admin\ImportOldDataController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\WhatsappInstanceController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\EnsureCanAccessMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'homePageAdmin'])->name('admin.home');

// Menu - Manage Users
Route::middleware([EnsureCanAccessMenu::class])->group(function() {
    Route::prefix('manage-users')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/', [ManageUsersController::class, 'userListPage'])->name('admin.manage-users');
            Route::get('create', [ManageUsersController::class, 'createUserPage'])->name('admin.manage-users.create');
            Route::post('create', [ManageUsersController::class, 'handleCreateUser'])->name('admin.manage-users.save');
            Route::get('detail', [ManageUsersController::class, 'userDetail'])->name('admin.manage-users.detail');
            Route::post('detail', [ManageUsersController::class, 'handleUpdateUsers'])->name('admin.manage-users.update');
            Route::post('status', [ManageUsersController::class, 'setStatus'])->name('admin.manage-users.set-status');
            Route::get('act-as', [ManageUsersController::class, 'actAsUser'])->name('admin.manage-users.act-as');
        });
    });

    // Menu - Manage Menu & Permissions
    Route::prefix('manage-menu')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/', [MenuController::class, 'menuListPage'])->name('admin.manage-menu');
            
            Route::get('store-parent', [MenuController::class, 'storeParentMenuPage'])->name('admin.manage-menu.parent');
            Route::post('store-parent', [MenuController::class, 'handleStoreParentMenu'])->name('admin.manage-menu.store-parent');
            Route::post('set-status', [MenuController::class, 'ajaxSetStatusParent'])->name('admin.manage-menu.set-status');
            Route::delete('delete', [MenuController::class, 'ajaxDeleteParentMenu'])->name('admin.manage-menu.delete');
            
            Route::get('store-child', [MenuController::class, 'storeChildMenuPage'])->name('admin.manage-menu.child');
            Route::post('store-child', [MenuController::class, 'handleStoreChildMenu'])->name('admin.manage-menu.store-child');
            Route::post('child/set-status', [MenuController::class, 'ajaxSetStatusChild'])->name('admin.manage-menu.child.set-status');
            Route::delete('child/delete', [MenuController::class, 'ajaxDeleteChildMenu'])->name('admin.manage-menu.child.delete');
            
            Route::get('permission', [MenuController::class, 'setPermissionPage'])->name('admin.manage-menu.permission');
            Route::post('permission', [MenuController::class, 'handleSetPermission'])->name('admin.manage-menu.permission.save');
            Route::delete('permission', [MenuController::class, 'ajaxDeletePermission'])->name('admin.manage-menu.permission.delete');
        });
    });

    Route::prefix('whatsapp-instance')->group(function() {
        Route::prefix('manage')->group(function() {
            Route::get('/', [WhatsappInstanceController::class, 'showPageWhatsappInstace'])->name('admin.whatsapp-intance');
            Route::post('delete-history', [WhatsappInstanceController::class, 'deleteAllHistory'])->name('admin.whatsapp-intance.delete-history');

            Route::get('connect', function (){
                return connect();
            })->name('admin.whatsapp-intance.connect');

            Route::get('disconnect', function(){
                return disconnect();
            })->name('admin.whatsapp-intance.disconnect');

            Route::get('status', function(){
                return waStatus();
            })->name('admin.whatsapp-intance.status');

            Route::get('getqr', function(){
                return waQr();
            })->name('admin.whatsapp-intance.getqr');
        });
    });

    Route::prefix('app-configs')->group(function() {
        Route::prefix('manage')->group(function() {
            Route::get('/', [AppConfigsController::class, 'showPageConfigs'])->name('admin.app-configs');
            Route::get('detail', [AppConfigsController::class, 'detailConfigs'])->name('admin.app-configs.detail');
            Route::post('update', [AppConfigsController::class, 'handleUpdateConfigs'])->name('admin.app-configs.update');
            Route::post('reset', [AppConfigsController::class, 'handleResetDefault'])->name('admin.app-configs.reset');
        });
    });

    Route::prefix('app-logs')->group(function() {
        Route::prefix('list')->group(function() {
            Route::get('/', [AppLogsController::class, 'showPageAppLogs'])->name('admin.app-logs');
            Route::post('delete', [AppLogsController::class, 'deleteAllLogs'])->name('admin.app-logs.delete');
        });
    });

    Route::prefix('import-export')->group(function() {
        Route::prefix('import')->group(function() {
            Route::get('/', [ImportOldDataController::class, 'showImportPage'])->name('admin.import');
            Route::post('classroom', [ImportOldDataController::class, 'handleImportClassrooms'])->name('admin.import.classroom');
            Route::post('dormitory', [ImportOldDataController::class, 'handleImportDormitories'])->name('admin.import.dormitory');
            Route::post('staff', [ImportOldDataController::class, 'handleImportStaffAccounts'])->name('admin.import.staff');
            Route::post('student', [ImportOldDataController::class, 'handleImportOldStudentAccounts'])->name('admin.import.student');
        });

        Route::prefix('export')->group(function() {
            
        });
    });
});