<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Bom\ProductController;
use App\Http\Controllers\Bom\ProjectController;
use App\Http\Controllers\Bom\CommerceController;
use App\Http\Controllers\Bom\PreOrderController;
use App\Http\Controllers\Master\StageController;
use App\Http\Controllers\Master\StateController;
use App\Http\Controllers\Master\SeasonController;
use App\Http\Controllers\Master\TdCodeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\BaseModelController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Bom\PurchaseOrderController;
use App\Http\Controllers\Bom\SampleRequestController;
use App\Http\Controllers\Api\StageController as ApiStageController;
use App\Http\Controllers\Api\ProjectController as ApiProjectController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\SampleRequestController as ApiSampleRequestController;
use App\Http\Controllers\Sr\SeasonalPoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Guest

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('/convert', [DashboardController::class, 'convertWordToPdf'])->name('convert.word.to.pdf');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index')->middleware(['permission:all activities']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.picture');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware(['permission:manage user']);

    // User Routes
    Route::group(['middleware' => ['permission:manage user']], function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/create/user', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{uuid}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/user/{uuid}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{uuid}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Role Routes
    Route::group(['middleware' => ['permission:manage role']], function () {
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');
        Route::post('/role', [RoleController::class, 'store'])->name('role.store');
        Route::patch('/role/{uuid}', [RoleController::class, 'update'])->name('role.update');
    });

    // File manager
    // Route::get('/filemanager', function () {
    //     return Inertia::render('Admin/FileManager/Index');
    // })->name('filemanager');
});

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

require __DIR__ . '/auth.php';
