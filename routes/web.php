<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
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

//All listing
Route::get('/',[Listingcontroller::class, 'index']);

// create listing
Route::get('/listing/create',[ListingController::class, 'create'])->middleware('auth');


//store listing
Route::post('/listing',[ListingController::class, 'store'])->middleware('auth');

//edit listing
Route::get('/listing/{listing}/edit',[ListingController::class, 'edit'])->middleware('auth');
// update listing
Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listing/{listing}',[ListingController::class, 'destroy'])->middleware('auth');

//show listing
Route::get('/listing/{listing}',[ListingController::class, 'show']);


//User routes show register/create form
Route::get('/register',[Usercontroller::class, 'create'])->middleware('guest');

Route::post('/users',[Usercontroller::class, 'store']);

Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate',[UserController::class, 'authenticate']);
