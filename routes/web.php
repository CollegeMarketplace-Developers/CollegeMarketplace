<?php

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
// use App\Http\Controllers\YardSaleController;
use App\Http\Controllers\RentablesController;
use App\Http\Controllers\SubleaseController;
use App\Http\Controllers\GoogleController;

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

//new master branch

// main routes

Route::get('/', [Controller::class, 'index']); //homepage
Route::get('/shop/all', [Controller::class, 'search']); //search page
Route::get('/item',[Controller::class,'getListingsFromLatLng']);

Route::get('/random/item', [Controller::class, 'getRandomItem']);

//---------------------------------------------------------------------

//User related routes

//private 
Route::get('/unreadmessages',[Controller::class,'getUnreadMessages']);//side panel
Route::get('/activeposts',[Controller::class,'getActivePosts']);//side panel
Route::get('/users/manage', [UserController::class, 'manage'])->middleware('auth');
Route::post('/users/manage/createWatchItem', [UserController::class, 'createWatchItem'])->middleware('auth');
Route::get('/users/removefavorite', [UserController::class, 'removeFavorite'])->middleware('auth');
Route::get('/users/addfavorite', [UserController::class, 'addFavorite'])->middleware('auth');
Route::post('/users/additionalInfo', [UserController::class, 'updateInfo'])->middleware('auth');
Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->middleware('auth');
Route::delete('/watchitems/{watchItem}', [UserController::class, 'deleteWatchItem']);
Route::post( '/remove_recommendation',[UserController::class, 'removeRecommendedItem']);

//Google Auth routes for login
Route::get('/login', [GoogleController::class, 'loginWithGoogle'])->name('login')->middleware('guest');
Route::any('/callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
Route::post('/logout', [GoogleController::class, 'logout'])->middleware('auth');

//user related routes no longer in use
//Route::get('/users/loginRegister', [UserController::class, 'create'])->name('login')->middleware('guest');
//Route::post('/users', [UserController::class, 'store'])->middleware('guest');
//Route::post('/users/authenticate',[UserController::class, 'authenticate']);

//----------------------------------------------------------------------

//messaging system related routes

//private routes
Route::post('/sendmessage', [MessageController::class, 'postMessage'])->middleware('auth');
Route::get('/messages', [MessageController::class, 'getMessages'])->middleware('auth');

//test change
//no longer active
// Route::get('/all/{type}/{itemID}/{ownerID}/{from}/messages', [MessageController::class, 'goToMessagePage'])->middleware('auth');

//----------------------------------------------------------------------

// Routes for listing items

//private routes
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
Route::put('/listings/{listing}/update', [ListingController::class, 'updateStatus'])->middleware('auth');
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
Route::put('/listings/{listing}',[ListingController::class, 'update'])->middleware('auth');
Route::delete('/listings/{listing}',[ListingController::class, 'destroy'])->middleware('auth');

//private routes
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//------------------------------------------------------------------------

// Routes for rentable items

//private routes
Route::get('/rentables/create', [RentablesController::class, 'create'])->middleware('auth');
Route::post('/rentables', [RentablesController::class, 'store'])->middleware('auth');
Route::put('/rentables/{rentable}/update', [RentablesController::class, 'updateStatus'])->middleware('auth');
Route::get('/rentables/{rentable}/edit', [RentablesController::class, 'edit'])->middleware('auth');
Route::put('/rentables/{rentable}',[RentablesController::class, 'update'])->middleware('auth');
Route::delete('/rentables/{rentable}',[RentablesController::class, 'destroy'])->middleware('auth');

//public routes
Route::get('/rentables/{rentable}', [RentablesController::class, 'show']);

//---------------------------------------------------------------------------

//Routes for Sublease items

// private routes
Route::get('/subleases/create', [SubleaseController::class, 'create'])->middleware('auth');
Route::post('/subleases', [SubleaseController::class, 'store'])->middleware('auth');
Route::put('/subleases/{sublease}/update', [SubleaseController::class, 'updateStatus'])->middleware('auth');
Route::get('/subleases/{sublease}/edit', [SubleaseController::class, 'edit'])->middleware('auth');
Route::put('/subleases/{sublease}',[SubleaseController::class, 'update'])->middleware('auth');
Route::delete('/subleases/{sublease}',[SubleaseController::class, 'destroy'])->middleware('auth');

//public routes
Route::get('/subleases/{sublease}', [SubleaseController::class, 'show']);

//-----------------------------------------------------------------------

//yard sales related routes

//not active at the moment
// Route::get('/yardsales/create', [YardSaleController::class, 'create'])->middleware('auth');
// Route::post('/yardsales', [YardSaleController::class, 'store'])->middleware('auth');
// Route::get('/yardsales/{yardsale}',[YardSaleController::class,'show']);

//-----------------------------------------------------------------

// supplementary routes for additional pages

Route::get('/features', [Controller::class, 'features']);
Route::get('/about', [Controller::class, 'about']);
Route::get('/services', [Controller::class, 'services']);
Route::post('/newsletter', [Controller::class, 'enrollEmail']);