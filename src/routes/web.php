<?php

use Illuminate\Support\Facades\Route;
use Nusagates\Larapay\Controllers\IpaymuController;


Route::group(['prefix' => 'larapay', 'middleware' => ['web']], function () {
    Route::get('/', [IpaymuController::class, 'index']);
});