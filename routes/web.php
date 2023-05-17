<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalpsController;

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

Route::get('/', function () {
    return view('welcome');
});

// menampilkan semua data
Route::get('/rental', [RentalpsController::class, 'index']);

//mengambil token
Route::get('/rental/token', [RentalpsController::class, 'createToken']);

//menambah data
Route::post('/rental/perental', [RentalpsController::class, 'store']);

// menampilkan sampah yang sudah di hapus di delete
Route::get('/rental/trash', [RentalpsController::class, 'trash']);

//mengambil data sesuai id
Route::get('/rental/show/{id}', [RentalpsController::class, 'show']);

//mengupdate data
Route::patch('/rental/update/{id}', [RentalpsController::class, 'update']);

//untuk menghapus data
Route::delete('/rental/delete/{id}', [RentalpsController::class, 'destroy']);

//untuk restore data
Route::get('/rental/trash/{id}', [RentalpsController::class, 'restore']);

//delete permanent
Route::get('/rental/show/trash/permanent/{id}', [RentalpsController::class, 'permanentDelete']);