<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoanOfficerController; // <- API namespace

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
Route::delete('/customerdestroy/{id}', [LoanOfficerController::class, 'customerdestroy'])
    ->name('customerdestroy');
// health check route:
Route::get('/health', function () {
    return response()->json([
        'status'  => 'ok',
        'version' => app()->version(),
    ], 200);
})->name('health');

