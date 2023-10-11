<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ShapefileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcludeRoadsController;
use App\Http\Controllers\MeasuringStationDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('add-user', [UserController::class, 'addUser']);
Route::post('sign-in', [UserController::class, 'signIn']);
Route::post('signed-in', [UserController::class, 'getAuthenticatedUser']);
Route::get('get-departments', [UserController::class, 'getDepartments']);
Route::post('create-shapefile', [ShapefileController::class, 'createShapefile']);
Route::get('download-shapefile', [ShapefileController::class, 'downloadShapefile']);
// Route::get('test', [ShapefileController::class, 'testController']);
Route::get('getcrs', [MapController::class, 'getCrs']);
Route::post('insert-exclude-roads', [ExcludeRoadsController::class, 'insertExcludeRoads']);
Route::post('get-measuring-data', [MeasuringStationDataController::class, 'getData']);
Route::get('test', [MapController::class, 'test']);
Route::get('test2', [MapController::class, 'test2']);
// Route::post('/sign-in', [UserController::class, 'signIn']);
// Route::get('/sign-in/test', [UserController::class, 'index']);
// Route::get('/admin', [UserController::class, 'testRoute']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
