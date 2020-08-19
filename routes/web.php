<?php

use App\Models\Offer;
use Illuminate\Support\Facades\Route;
define('PAGINATION_COUNT',10);

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
Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', 'LoginController@getLogin')->name('get.admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');
});
Route::get('/', function () {
    $offers = Offer::get();
    if(auth()->id()>=1)
    $cartItems = \Cart::session(auth()->id())->getContent();
    else
        $cartItems='';
    return view('front.home',compact('offers','cartItems'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('comment', 'HomeController@saveComment')->name('comment.save');


################Begin paymentGateways Routes ########################

Route::group(['prefix' => 'offers', 'middleware' => 'auth','namespace' =>'Offers'], function () {
    Route::get('/', 'OfferController@index')->name('offers.all');
    Route::get('details/{offer_id}', 'OfferController@show')->name('offers.show');
});

Route::get('get-checkout-id', 'PaymentProviderController@getCheckOutId')->name('offers.checkout');


Route::get('/add-to-cart/{product}', 'CartController@add')->name('cart.add')->middleware('auth');
Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');
Route::get('/cart/destroy/{itemId}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');
Route::get('/cart/update/{itemId}', 'CartController@update')->name('cart.update')->middleware('auth');
Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::get('/cart/apply-coupon', 'CartController@applyCoupon')->name('cart.coupon')->middleware('auth');

################End paymentGateways Routes ########################





