<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//   return $request->user();
// });


//Route::group(['prefix' => 'po'], function () {
Route::post('/save_po_local', [App\Http\Controllers\PoController::class, 'save_po_to_local'])->name('save_po');
//});
