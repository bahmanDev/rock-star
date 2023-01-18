<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\OrderController;
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


/**---------------------------------------------------------------------------------------------------------
 * Admin Route
 **---------------------------------------------------------------------------------------------------------
 */
Route::middleware('admin')->prefix('admin')->group(function (){
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});


/**---------------------------------------------------------------------------------------------------------
 * Auth Route
 **---------------------------------------------------------------------------------------------------------
 */
Route::controller(AuthController::class)->group(function (){
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

/**---------------------------------------------------------------------------------------------------------
 * Client Route
 **---------------------------------------------------------------------------------------------------------
 */
Route::middleware('auth')->group(function (){
    Route::resource('orders', OrderController::class)->only(['index', 'store', 'show']);
});
