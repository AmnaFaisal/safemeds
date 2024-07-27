<?php

use App\Http\Controllers\Backend as Backend;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

// Backend Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [Backend\DashboardController::class, 'index'])->name('dashboard');
    // Profile Routes
    Route::resource('profile', Backend\ProfileController::class);
    Route::put('change-password/{id}', [Backend\ProfileController::class, 'changePassword'])->name('change-password');
    // Users Routes
    Route::resource('users', Backend\UserController::class);
    Route::get('users-dt', [Backend\UserController::class, 'dataTable'])->name('users-datatable');
    // Roles Routes
    Route::resource('roles', Backend\RoleController::class);
    Route::get('roles-dt', [Backend\RoleController::class, 'dataTable'])->name('roles-datatable');
    //patient Routes
    Route::resource('patients', Backend\PatientController::class);
    Route::get('patients-dt', [Backend\PatientController::class, 'dataTable'])->name('patients-datatable');
    // //medications Routes
    Route::resource('medications', Backend\MedicationController::class);
    Route::get('patients-search', [Backend\MedicationController::class, 'search'])->name('search.patients');
    Route::post('medication/Form', [Backend\MedicationController::class, 'medicationForm'])->name('medication.Form');
    // Report Routes
    Route::get('write-prescription',[Backend\ReportController::class, 'writePrescription'])->name('reports.write-prescription');
    Route::get('view-prescription/{id}',[Backend\ReportController::class, 'viewPrescription'])->name('prescription.show');
    Route::get('view-prescription', [Backend\ReportController::class, 'viewPrescription'])->name('approve-report');
    Route::match (['get', 'post'], 'update-prescription-status/{id}/{status?}', [Backend\ReportController::class, 'updatePrescriptionStatus'])->name('update-report-status');
    Route::get('/getMedicationDetails',[Backend\ReportController::class, 'getMedicationDetails'])->name('get.Medication.Details');
    
    Route::get('reports/{status}', [Backend\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/rejected/edit/{id}',[Backend\ReportController::class, 'edit'])->name('reports.edit');
    Route::put('reports-edit/{id}',[Backend\ReportController::class, 'update'])->name('reports.update');
    Route::get('reports-dt/{status}', [Backend\ReportController::class, 'dataTable'])->name('reports-datatable');
});

// Frontend Routes
Route::redirect('/', '/login');
