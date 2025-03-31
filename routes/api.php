<?php

use Illuminate\Support\Facades\Route;
use App\InternalAPI\V1\Books\Actions\GetBestSellersAction;

Route::prefix('v1')
    ->name('v1')
    ->group(function () {
        Route::prefix('books')
            ->name('books')
            ->group(function () {
                Route::get('best_sellers', GetBestSellersAction::class);
            });
    });
