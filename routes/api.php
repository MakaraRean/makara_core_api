<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\DebtorController;
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
Route::GET('/debtor/get', [DebtorController::class, 'get_debtors']);
Route::POST('/debtor/add', [DebtorController::class, 'add_debtor']);
Route::PUT('/debtor/update', [DebtorController::class, 'update']);
Route::PUT('/debtor/pay', [DebtorController::class, 'pay']);

Route::GET('/debt/get', [DebtController::class, 'get']);
Route::GET('/debt/getByDebtor/{id}', [DebtController::class, 'getByDebtor']);
Route::POST('/debt/add', [DebtController::class, 'add']);
Route::PUT('/debt/update', [DebtController::class, 'update']);
Route::PUT('/debt/pay', [DebtController::class, 'pay']);

Route::get('viewer/add', [Controller::class, 'addVisiter']);
