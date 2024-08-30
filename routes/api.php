<?php

use App\Http\Controllers\RouteController;
use App\Models\Endpoint;
use Illuminate\Support\Facades\Route;

foreach (Endpoint::all() as $route) {
    Route::match([$route->method], $route->url, [RouteController::class, 'response']);
}
