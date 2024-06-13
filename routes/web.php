<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\CsvScrubController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ManualNumberCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;



// admin routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/adminUser', [AdminUserController::class, 'index'])->name('adminUser.index');
    Route::get('adminUser/create', [AdminUserController::class, 'create'])->name('adminUser.create');
    Route::post('adminUser/store', [AdminUserController::class, 'store'])->name('adminUser.store');
    Route::get('/adminUser/{id}/edit', [AdminUserController::class, 'edit'])->name('adminUser.edit');
    Route::put('/adminUser/{id}', [AdminUserController::class, 'update'])->name('adminUser.update');
    Route::delete('/adminUser/{id}', [AdminUserController::class, 'destroy'])->name('adminUser.destroy');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users/store', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{menu}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{menu}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{menu}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{menu}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{menu}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{menu}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('csv-import', [CsvImportController::class, 'index'])->name('csv-import.index');
    Route::post('csv-import/store', [CsvImportController::class, 'store'])->name('csv-import.store');

    Route::get('/scrub-import', [CsvScrubController::class, 'import'])->name('csv-check.import');
    // Route::post('csv-import/store', [CsvScrubController::class, 'checkDuplicates'])->name('csv-import.checkDuplicates');
    Route::get('/scan', [CsvScrubController::class, 'import'])->name('scanForm');
    Route::post('/scan', [CsvScrubController::class, 'checkDuplicates'])->name('scan');
    Route::get('/scanned-numbers', [CsvScrubController::class, 'results'])->name('csv-scanned-numbers');
});

//user routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/scrub-form', [CsvScrubController::class, 'index'])->name('csv-check.index');
    Route::post('/scrub', [CsvScrubController::class, 'scrub'])->name('csv-check.scrub');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
