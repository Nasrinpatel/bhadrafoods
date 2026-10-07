<?php

use BhadraFoods\Custom\Http\Controllers\BulkOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'core']], function (): void {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function (): void {
        Route::post('bulk-order-contact', [BulkOrderController::class, 'send'])->name('public.bulk-order.send');
    });
});
