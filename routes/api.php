<?php

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AvantagesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersPreferencesController;
use App\Models\BannedUsers;
use App\Models\BlockedUsers;
use App\Models\BuyLogs;
use App\Models\Conversations;
use App\Models\Dislikes;
use App\Models\Likes;
use App\Models\Messages;
use App\Models\Photos;
use App\Models\ReportedUsers;
use App\Models\Subscriptions;
use App\Models\SuperLikes;
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
Route::controller(LoginController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('adminUsers', AdminUsersController::class);
    Route::resource('avantages', AvantagesController::class);
    Route::resource('bannedUsers', BannedUsers::class);
    Route::resource('blockedUsers', BlockedUsers::class);
    Route::resource('buyLogs', BuyLogs::class);
    Route::resource('conversations', Conversations::class);
    Route::resource('dislikes', Dislikes::class);
    Route::resource('likes', Likes::class);
    Route::resource('messages', Messages::class);
    Route::resource('photos', Photos::class);
    Route::resource('reportedUsers', ReportedUsers::class);
    Route::resource('subscriptions', Subscriptions::class);
    Route::resource('superLikes', SuperLikes::class);
    Route::resource('users', UserController::class);
    Route::resource('usersPreferences', UsersPreferencesController::class);
});
