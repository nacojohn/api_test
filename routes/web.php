<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/success', function () {
    return response('<h1>Donation Successful</h1>');
});

Route::get('/failed', function () {
    return response('<h1>Donation Failed</h1>');
});

Route::get('/error', function () {
    return response('<h1>Donation Encountered an error</h1>');
});

Route::post('/callback', 'TransactionController@addTransaction');