<?php

use BhadraFoods\PhonePeV2\Http\Controllers\PhonePeController;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function () {
    Route::get('payment/phonepe-v2/callback', [PhonePeController::class, 'callback'])
        ->name('payment.phonepe-v2.callback');

    Route::post('payment/phonepe-v2/webhook', [PhonePeController::class, 'webhook'])
        ->withoutMiddleware('web')
        ->name('payment.phonepe-v2.webhook');
});
