<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Models\User;
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


Route::resource('domain', DomainController::class);
Route::resource('users', UserController::class);
Route::resource('vendor', VendorController::class);
Route::resource('todolist', TodoListController::class);
Route::resource('package', PackageController::class);
Route::resource('template', TemplateController::class);
Route::resource('order', OrderController::class);
Route::get('order-by-user-id/{id}', [OrderController::class, 'dataByUserId']);
Route::get('order-by-code/{code}', [OrderController::class, 'dataByCode']);
Route::post('order-process', [OrderController::class, 'process']);
Route::post('payment', [OrderController::class, 'payment']);
Route::get('todolist/user/{todolist}', [TodoListController::class, 'getDataByUser']);
Route::post('todolist-submit/', [TodoListController::class, 'submit']);
Route::post('todolist-confirm-order/', [TodoListController::class, 'confirmOrder']);
Route::post('todolist/change-status', [TodoListController::class, 'changeStatus']);
Route::post('todolist/change-note', [TodoListController::class, 'changeNote']);
Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('dashboard-support/{user}', [DashboardController::class, 'indexSupport']);


Route::get('/chat/{user}', function (User $user) {
    return view('chat', [
        'user' => $user
    ]);
})->name('chat');



Route::get('messages/user/{user}', [ChatController::class, 'index']);
Route::post('messages/user/', [ChatController::class, 'store']);
