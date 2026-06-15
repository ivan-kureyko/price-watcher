<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'subscribe');

Route::post('/subscriptions', [SubscriptionController::class, 'storeFromWeb']);
