<?php

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

// make donation
Route::post('/make-donation','DonationController@addDonation');

// view donations
Route::get('/view-donations','DonationController@viewDonations');

// view transactions
Route::get('/view-transactions','TransactionController@viewTransactions');