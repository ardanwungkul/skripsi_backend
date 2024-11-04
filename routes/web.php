<?php

use App\Http\Controllers\OrderController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\CustomerObject;
use Xendit\Invoice\InvoiceApi;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function () {

    return ['Laravel' => app()->version()];
});

Route::get('/checkout', [OrderController::class, 'order']);
Route::get('/payment/check/{code}', [OrderController::class, 'return'])->name('order.return');
Route::get('/broadcasting/auth', function () {
    return response()->json(['message' => 'Broadcasting Auth Endpoint']);
});

require __DIR__ . '/auth.php';
