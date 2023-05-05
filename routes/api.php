<?php

use App\Http\Controllers\API\ApiController;
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

//api for all tables
Route::controller(ApiController::class)->group(function(){

    //retriving data
    Route::get('users','getAllUsersWithoutId');
    Route::get('users/{id}','getAllUsersWithId');
    Route::get('categories','getAllCategoriesWithoutId');
    Route::get('categories/{id}','getAllCategoriesWithId');
    Route::get('products','getAllProductsWithoutId');
    Route::get('products/{id}','getAllProductsWithId');
    Route::get('contacts','getAllContactsWithoutId');
    Route::get('contacts/{id}','getAllContactsWithId');

    //creating data
    Route::post('createCategory','createCategory');

    //updating data
    Route::get('updateCategory/{id}','updateCategory');

    //deleting data
    Route::get('deleteCategory/{id}','deleteCategory');
});
