<?php

use App\Http\Controllers\DworController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home',[
//         "judul" => "home"
//     ]);
// });

// Route::get('/about', function () {
//     $blog_ku = post::all();

 
//     return view('about',[
//         "judul" => "about",
//         // "name" => "sandika uno",
//         // "email" => "coba",
//         // "image" =>"logo.png"
//         "posts" => $blog_ku
//     ]);
// });

Route::get('/',[DworController::class,'index'])->name('dwor.index');

Route::get('/dwor/{poli}', [DworController::class, 'utama'])->name('dwor.utama');
Route::get('/jri',[DworController::class,'jri'])->name('jri');
Route::get('/jkpl',[DworController::class,'jkpl'])->name('jkpl');
Route::get('/jkpb',[DworController::class,'jkpb'])->name('jkpb');
Route::get('/bor',[DworController::class,'bor'])->name('bor');