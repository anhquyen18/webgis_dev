<?php

use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ShapefileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcludeRoadsController;
use App\Http\Controllers\MeasuringStationDataController;
use App\Http\Controllers\SwmmController;
use App\Http\Controllers\UserStatusController;

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

Route::post('check-username', [UserController::class, 'checkUsername']);
Route::post('sign-up', [UserController::class, 'signUp']);
Route::post('insert-signup-user', [UserController::class, 'insertSignUpUser']);
Route::post('send-email-reset-password', [UserController::class, 'sendEmailResetPassword']);
Route::post('check-reset-link', [UserController::class, 'checkResetPasswordLink']);
Route::post('reset-password', [UserController::class, 'resetPassword']);
// Route::post('sign-up-user', [UserController::class, 'signUpUser']);
Route::group(['middleware' => 'jwt'], function () {

    Route::post('signed-in', [UserController::class, 'getAuthenticatedUser']);
    Route::post('user-update-info', [UserController::class, 'userUpdateInfo']);
    Route::post('user-update-password', [UserController::class, 'userUpdatePassword']);
});

Route::group(['middleware' => ['jwt', 'jwt.role:3']], function () {
    // Route::get('get-users-manager', [UserController::class, 'index']);
    Route::post('get-users-manager', [UserController::class, 'getUsersManager']);
    Route::post('search-users', [UserController::class, 'searchUsers']);
});

Route::get('get-departments', [DepartmentsController::class, 'index']);

Route::post('create-shapefile', [ShapefileController::class, 'createShapefile']);
Route::get('download-shapefile', [ShapefileController::class, 'downloadShapefile']);
Route::post('search-feature', [ShapefileController::class, 'searchFeature']);
Route::post('get-geoserver-feature-by-id', [ShapefileController::class, 'getGeoserverFeatureById']);
// Route::get('test', [ShapefileController::class, 'testController']);
Route::get('getcrs', [MapController::class, 'getCrs']);
Route::get('test', [MapController::class, 'test']);
Route::get('test1', [MapController::class, 'test1']);
Route::get('test2', [MapController::class, 'test2']);

Route::post('insert-exclude-roads', [ExcludeRoadsController::class, 'insertExcludeRoads']);
Route::post('get-measuring-data', [MeasuringStationDataController::class, 'getData']);

Route::get('get-user-status', [UserStatusController::class, 'index']);



Route::get('send-verification-email', [EmailVerificationController::class, 'sendVerificationEmail']);
// Route::post('/sign-in', [UserController::class, 'signIn']);
// Route::get('/admin', [UserController::class, 'testRoute']);

Route::get('read-inp', [SwmmController::class, 'readInp']);
Route::get('write-inp', [SwmmController::class, 'writeInp']);
Route::get('read-rpt', [SwmmController::class, 'readRpt']);
Route::get('read-out', [SwmmController::class, 'readOut']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
