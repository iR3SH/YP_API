<?php

use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AvantagesController;
use App\Http\Controllers\BannedUsersController;
use App\Http\Controllers\BlockedUsersController;
use App\Http\Controllers\BuyLogsController;
use App\Http\Controllers\ConversationsController;
use App\Http\Controllers\DislikesController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ReportedUsersController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\SuperLikesController;
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
//Route::put('photos', 'PhotosController@update')->name('photos.update');
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('adminUsers', AdminUsersController::class);
    Route::resource('avantages', AvantagesController::class);
    Route::resource('bannedUsers', BannedUsersController::class);
    Route::resource('blockedUsers', BlockedUsersController::class);
    Route::resource('buyLogs', BuyLogsController::class);
    Route::resource('conversations', ConversationsController::class);
    Route::resource('dislikes', DislikesController::class);
    Route::resource('likes', LikesController::class);
    Route::resource('messages', MessagesController::class);
    Route::resource('photos', PhotosController::class);
    Route::resource('reportedUsers', ReportedUsersController::class);
    Route::resource('subscriptions', SubscriptionsController::class);
    Route::resource('superLikes', SuperLikesController::class);
    Route::resource('users', UserController::class);
    Route::resource('usersPreferences', UsersPreferencesController::class);
});
