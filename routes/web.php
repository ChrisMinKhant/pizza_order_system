<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\user\AjaxController;
use App\Http\Controllers\user\UserController;
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


// Login & Register Routes
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');

    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});


Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('dashboard', [AuthController::class, 'checkCondition']);

    Route::middleware(['admin_auth'])->group(function () {
        //adminn
        //category
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'listPage'])->name('category#listPage');
            Route::get('createPage', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'createCategory'])->name('category#create');
            Route::get('delete/{id?}', [CategoryController::class, 'deleteCategory'])->name('category#delete');
            Route::get('edit/{id?}', [CategoryController::class, 'editCategory'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'updateCategory'])->name('category#update');
        });

        //account
        Route::prefix('admin')->group(function () {
            //password
            Route::get('passsword/changePage', [AdminController::class, 'passwordChangePage'])->name('admin#passwordchangepage');
            Route::post('password/change', [AdminController::class, 'passwordChange'])->name('admin#passwordchange');

            //info
            Route::get('account/info/show', [AdminController::class, 'accountInfoShowPage'])->name('admin#accountinfo#show');
            Route::get('account/info/edit', [AdminController::class, 'accountInfoEditPage'])->name('admin#accountinfo#edit');
            Route::post('account/info/update/{id}', [AdminController::class, 'accountInfoUpdate'])->name('admin#accountinfo#update');

            //admin list
            Route::get('listPage',[AdminController::class,'adminListPage'])->name('admin#listpage');
            Route::get('listDelete/{id}',[AdminController::class,'adminListDelete'])->name('admin#listdelete');
            Route::get('roleChange/{id}',[AdminController::class,'adminRoleChange'])->name('admin#rolechange');

            //product
            Route::get('product/listPage', [ProductController::class, 'productListPage'])->name('admin#product#listPage');
            Route::get('product/createPage', [ProductController::class, 'productCreatePage'])->name('admin#product#createPage');
            Route::post('product/create', [ProductController::class, 'productCreate'])->name('admin#product#create');
            Route::get('delete/{id?}',[ProductController::class,'deleteProduct'])->name('admin#product#delete');
            Route::get('product/detailPage/{id?}',[ProductController::class,'productDetailPage'])->name('admin#product#detailPage');
            Route::get('product/editPage/{id?}',[ProductController::class,'productEditPage'])->name('admin#product#editPage');
            Route::post('product/update',[ProductController::class,'productUpdate'])->name('admin#product#update');

            //order
            Route::prefix('order')->controller(OrderController::class)->group(function(){
                Route::get('listPage','orderListPage')->name('admin#order#listPage');
                Route::post('searchWithStatus','searchWithStatus')->name('admin#order#searchWithStatus');
                Route::get('searchData','searchData')->name('admin#order#searchData');
                Route::get('changeStatus','changeOrderStatus')->name('admin#order#changeStatus');
                Route::get('productList/{orderCode}','productList')->name('admin#order#productList');
            });

            //user
            Route::prefix('user')->controller(AdminController::class)->group(function(){
                Route::get('listPage','userListPage')->name('admin#userListPage');
                Route::get('changeUserRole','changeUserRole')->name('admin#changeUserRole');
                Route::get('editUserInfoPage/{requestedUserId}','editUserInfoPage')->name('admin#editUserInfoPage');
                Route::get('updateUserInfo/{userId}','updateUserInfo')->name('admin#updateUserInfo');
                Route::get('deleteUser','deleteUser')->name('admin#deleteUser');
            });

            //contact
            Route::prefix('contact')->controller(ContactController::class)->group(function(){
                Route::get('messageListPage','messageListPage')->name('admin#contact#messageListPage');
                Route::get('messageDetailPage/{id}','messageDetailPage')->name('admin#contact#messageDetailPage');
                Route::get('deleteMessage/{id}','deleteMessage')->name('admin#contact#deleteMessage');
            });
        });
    });

    //user
    //home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {

        //home page
        Route::get('home',[UserController::class,'home'])->name('user#homepage');
        Route::get('categoryFilter/{id}',[UserController::class,'categoryFilter'])->name('user#categoryfilter');
        Route::get('history',[UserController::class,'historyPage'])->name('user#historypage');

        //cart
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cart#list');
        });

        Route::prefix('product')->group(function(){
            Route::get('detailPage/{id}',[UserController::class,'productDetailPage'])->name('user#product#detailpage');
        });

        //user password
        Route::prefix('password')->group(function(){
            Route::get('changePage',[UserController::class,'passwordChangePage'])->name('user#password#changepage');
            Route::post('change',[UserController::class,'passwordChange'])->name('user#password#change');
        });

        //user account
        Route::prefix('account')->group(function(){
            Route::get('editPage',[UserController::class,'accountEditPage'])->name('user#account#editpage');
            Route::post('edit/{id}',[UserController::class,'accountEdit'])->name('user#account#edit');
        });

        //user contact
        ROute::prefix('contact')->controller(UserController::class)->group(function(){
            Route::get('contactPage','contactPage')->name('user#contactPage');
            Route::post('sentMessage','sentMessage')->name('user#sentMessage');
        });

        //ajax
        Route::prefix('ajax')->group(function(){
            Route::get('productlist',[AjaxController::class,'productList'])->name('user#ajax#productlist');
            Route::get('addToCart',[AjaxController::class,'addToCart'])->name('user#ajax#addtocart');
            Route::get('listOrder',[AjaxController::class,'listOrder'])->name('user#ajax#listorder');
            Route::get('removeCartItem',[AjaxController::class,'removeCartItem'])->name('user#ajax#removecartitem');
            Route::get('clearCart',[AjaxController::class,'clearCart'])->name('user#ajax#clearcart');
        });

    });
});
