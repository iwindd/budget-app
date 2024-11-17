<?php

use App\Http\Controllers\AffiliationController;
use App\Http\Controllers\BudgetAdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExportBudgetController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

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

/* GUEST ROUTES */
Route::get('/', fn() => redirect("login"));

/* USER & ADMIN ROUTES */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/selectize/companions', [UserController::class, 'companion'])->name('companions.selectize');
    Route::get('/selectize/locations', [LocationController::class, 'locations'])->name('locations.selectize');
    Route::get('/selectize/expenses', [ExpenseController::class, 'expenses'])->name('expenses.selectize');

    Route::get('/budgets/{budget}/document', [ExportBudgetController::class, 'document'])->name('budgets.export.document');
    Route::get('/budgets/{budget}/evidence', [ExportBudgetController::class, 'evidence'])->name('budgets.export.evidence');
    Route::get('/budgets/{budget}/certificate', [ExportBudgetController::class, 'certificate'])->name('budgets.export.certificate');
    Route::get('/budgets/{budget}/travel', [ExportBudgetController::class, 'travel'])->name('budgets.export.travel');
});

/* USER ROUTES */
Route::middleware('role:user')->group(function () {
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets');
    Route::get('/budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show');
    Route::post('/budgets/{budget}', [BudgetController::class, 'store'])->name('budgets.upsert');
    Route::post('/budgets', [BudgetController::class, 'find'])->name('budgets.find');
});

/* ADMIN ROUTES */
Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::get('/budgets', [BudgetAdminController::class, 'index'])->name('budgets.admin');
    Route::get('/budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show.admin');

    Route::get("/users", [UserController::class, 'index'])->name('users');

    Route::prefix('document')->group(function () {
        Route::get("/positions", [PositionController::class, 'index'])->name('positions');
        Route::get("/affiliations", [AffiliationController::class, 'index'])->name('affiliations');
        Route::get("/locations", [LocationController::class, 'index'])->name('locations');
        Route::get("/expenses", [ExpenseController::class, 'index'])->name('expenses');
        Route::get("/invitations", [InvitationController::class, 'index'])->name('invitations');
        Route::get("/offices", [OfficeController::class, 'index'])->name('offices');
    });
});

/* AUTH ROUTES */
require __DIR__ . '/auth.php';
