<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\HostingPlanController;
use App\Http\Controllers\Api\HostingPlanTypeController;
use App\Http\Controllers\Api\NavbarController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\SkillsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TestimonialsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/storage/uploads/logos/{filename}', [ClientsController::class, 'assets']);

Route::get('/navbar', [NavbarController::class, 'index']);
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/hosting-plans', [HostingPlanController::class, 'index']);
Route::get('/hosting-plan-types', [HostingPlanTypeController::class, 'index']);
Route::get('/clients', [ClientsController::class, 'index']);
Route::get('/testimonials', [TestimonialsController::class, 'index']);
Route::get('/team', [TeamController::class, 'index']);
Route::get('/skill', [SkillsController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);