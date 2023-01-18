<?php

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersPreferencesController;
use App\Models\BannedUsers;
use App\Models\BlockedUsers;
use App\Models\ReportedUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('users', UserController::class);
Route::resource('adminUsers', AdminUsersController::class);
Route::resource('usersPreferences', UsersPreferencesController::class);
Route::resource('reportedUsers', ReportedUsers::class);
Route::resource('blockedUsers', BlockedUsers::class);
Route::resource('bannedUsers', BannedUsers::class);
