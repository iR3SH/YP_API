<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AvantagesController;
use App\Http\Controllers\BannedUsersController;
use App\Http\Controllers\BlockedUsersController;
use App\Http\Controllers\BuyLogsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ConsolesController;
use App\Http\Controllers\ConversationsController;
use App\Http\Controllers\DislikesController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\JeuxController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MatchsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MovieTypeController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\PlateformesController;
use App\Http\Controllers\ReportedUsersController;
use App\Http\Controllers\SearchPremiumController;
use App\Http\Controllers\SimpleSearchController;
use App\Http\Controllers\SortiesController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\SuperLikesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersActivitiesController;
use App\Http\Controllers\UsersPreferencesController;
use App\Http\Controllers\UsersPrefsActivitiesController;
use App\Models\ActivitiesType;
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

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('activities', ActivitiesController::class);
    Route::resource('activitiesType', ActivitiesType::class);
    Route::resource('adminPanel', AdminPanelController::class);
    Route::resource('adminUsers', AdminUsersController::class);
    Route::resource('avantages', AvantagesController::class);
    Route::resource('bannedUsers', BannedUsersController::class);
    Route::resource('blockedUsers', BlockedUsersController::class);
    Route::resource('buyLogs', BuyLogsController::class);
    Route::resource('changePassword', ChangePasswordController::class);
    Route::resource('consoles', ConsolesController::class);
    Route::resource('conversations', ConversationsController::class);
    Route::resource('dislikes', DislikesController::class);
    Route::resource('jeux', JeuxController::class);
    Route::resource('likes', LikesController::class);
    Route::resource('matchs', MatchsController::class);
    Route::resource('messages', MessagesController::class);
    Route::resource('movieType', MovieTypeController::class);
    Route::resource('photos', PhotosController::class);
    Route::resource('plateformes', PlateformesController::class);
    Route::resource('reportedUsers', ReportedUsersController::class);
    Route::resource('searchPremium', SearchPremiumController::class);
    Route::resource('simpleSearch', SimpleSearchController::class);
    Route::resource('sorties', SortiesController::class);
    Route::resource('sports', SportsController::class);
    Route::resource('subscriptions', SubscriptionsController::class);
    Route::resource('superLikes', SuperLikesController::class);
    Route::resource('users', UserController::class);
    Route::resource('usersActivities', UsersActivitiesController::class);
    Route::resource('usersPreferences', UsersPreferencesController::class);
    Route::resource('usersPrefsActivities', UsersPrefsActivitiesController::class);
});
