<?php

use App\InternalAPI\V1\Books\Actions\BestSellerAction;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('v1')
    ->group(function () {
        Route::prefix('books')
            ->name('.books')
            ->group(function () {
                Route::get('best_sellers', BestSellerAction::class);
            });
    });
