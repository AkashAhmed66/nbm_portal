<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resources([
        'service-types' => ServiceTypeController::class,
        'service-categories' => ServiceCategoryController::class,
        'services' => ServiceController::class,
        'certificate' => CertificateController::class,
        'report-categories' => ReportCategoryController::class,
        'report' => ReportController::class,
        'news' => NewsController::class,
    ]);
});

Route::get('/api/services', [ServiceController::class, 'serviceList'])->name('api.services');
Route::get('/api/service-details/{id}', [ServiceController::class, 'serviceDetails'])->name('api.service-details');
Route::get('/api/category-wise-service/{id}', [ServiceController::class, 'categoryWiseService'])->name('api.category-wise-service');
Route::get('/api/news', [NewsController::class, 'allNews'])->name('api.news');
Route::get('/api/report-categories', [ReportCategoryController::class, 'allReportCategories'])->name('api.reportCategories');

