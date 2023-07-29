<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('permission:view_dashboard');
  Route::get('/view', [AdminController::class, 'manageAdmins'])->middleware('permission:view-admin');
});

Route::group(['prefix' => 'user'], function () {
  Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->middleware('permission:view_user');
  Route::get('/view', [AdminController::class, 'manageAdmins'])->middleware('permission:view-admin');
  Route::post('/get_list', [App\Http\Controllers\UsersController::class, 'get_list'])->middleware('permission:view_user');
  Route::post('/save', [App\Http\Controllers\UsersController::class, 'save'])->middleware('permission:add_user');
  Route::post('/save_edit', [App\Http\Controllers\UsersController::class, 'save_edit'])->middleware('permission:edit_user');
  Route::post('/delete_user', [App\Http\Controllers\UsersController::class, 'delete_user'])->middleware('permission:delete_user');
  Route::post('/del_role', [App\Http\Controllers\UsersController::class, 'del_role'])->middleware('permission:add_user');
  Route::post('/save_role', [App\Http\Controllers\UsersController::class, 'save_role'])->middleware('permission:add_user');
  Route::post('/get_role', [App\Http\Controllers\UsersController::class, 'get_role'])->middleware('permission:add_user');
});

Route::group(['prefix' => 'role'], function () {
  Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->middleware('permission:view_role');
  Route::post('/get_list', [App\Http\Controllers\RoleController::class, 'get_list'])->middleware('permission:view_role');
  Route::post('/save', [App\Http\Controllers\RoleController::class, 'save'])->middleware('permission:add_role');
  Route::post('/save_edit', [App\Http\Controllers\RoleController::class, 'save_edit'])->middleware('permission:edit_role');
  Route::post('/del_permission', [App\Http\Controllers\RoleController::class, 'del_permission'])->middleware('permission:delete_role');
  Route::post('/del_role_permission', [App\Http\Controllers\RoleController::class, 'del_role_permission'])->middleware('permission:delete_role');
  Route::post('/save_permission', [App\Http\Controllers\RoleController::class, 'save_permission'])->middleware('permission:add_role');
  Route::post('/get_permission', [App\Http\Controllers\RoleController::class, 'get_permission'])->middleware('permission:add_role');
});

Route::group(['prefix' => 'permission'], function () {
  Route::get('/', [App\Http\Controllers\PermissionController::class, 'index'])->middleware('permission:view_permission');
  Route::post('/get_list', [App\Http\Controllers\PermissionController::class, 'get_list'])->middleware('permission:view_permission');
  Route::post('/save', [App\Http\Controllers\PermissionController::class, 'save'])->middleware('permission:add_permission');
  Route::post('/save_edit', [App\Http\Controllers\PermissionController::class, 'save_edit'])->middleware('permission:edit_permission');
  Route::post('/del_permission', [App\Http\Controllers\PermissionController::class, 'del_permission'])->middleware('permission:delete_permission');
  Route::post('/del_role_permission', [App\Http\Controllers\PermissionController::class, 'del_role_permission'])->middleware('permission:delete_permission');
  Route::post('/save_permission', [App\Http\Controllers\PermissionController::class, 'save_permission'])->middleware('permission:add_permission');
  Route::post('/get_permission', [App\Http\Controllers\PermissionController::class, 'get_permission'])->middleware('permission:add_permission');
});

Route::group(['prefix' => 'po'], function () {
  Route::get('/', [App\Http\Controllers\PoController::class, 'index'])->middleware('permission:view_po');
  Route::post('/get_list', [App\Http\Controllers\PoController::class, 'get_list'])->middleware('permission:view_po');
});

Route::group(['prefix' => 'unit'], function () {
  Route::get('/', [App\Http\Controllers\UnitController::class, 'index'])->middleware('permission:view_unit');
  Route::post('/get_list', [App\Http\Controllers\UnitController::class, 'get_list'])->middleware('permission:view_unit');
  Route::post('/save', [App\Http\Controllers\UnitController::class, 'save'])->middleware('permission:add_unit');
  Route::post('/save_edit', [App\Http\Controllers\UnitController::class, 'save_edit'])->middleware('permission:edit_unit');
  Route::post('/delete_unit', [App\Http\Controllers\UnitController::class, 'delete'])->middleware('permission:delete_unit');
});

Route::group(['prefix' => 'jenis_surat'], function () {
  Route::get('/', [App\Http\Controllers\JenisSuratController::class, 'index'])->middleware('permission:view_jenis_surat');
  Route::post('/get_list', [App\Http\Controllers\JenisSuratController::class, 'get_list'])->middleware('permission:view_jenis_surat');
  Route::post('/save', [App\Http\Controllers\JenisSuratController::class, 'save'])->middleware('permission:add_jenis_surat');
  Route::post('/save_edit', [App\Http\Controllers\JenisSuratController::class, 'save_edit'])->middleware('permission:edit_jenis_surat');
  Route::post('/delete_jenis_surat', [App\Http\Controllers\JenisSuratController::class, 'delete'])->middleware('permission:delete_jenis_surat');
});

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'destroy']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'index'])->name('reset-password');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::get('/', [App\Http\Controllers\AuthController::class, 'login']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
