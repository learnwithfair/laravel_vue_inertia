<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get( '/', function () {
    return Inertia::render( 'Home', [
        'canLogin'       => Route::has( 'login' ),
        'canRegister'    => Route::has( 'register' ),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ] );
} )->name( 'home' );

Route::get( '/dashboard', function () {
    return Inertia::render( 'Dashboard' );
} )->middleware( ['auth', 'verified'] )->name( 'dashboard' );

Route::middleware( 'auth' )->group( function () {
    Route::get( '/profile', [ProfileController::class, 'edit'] )->name( 'profile.edit' );
    Route::patch( '/profile', [ProfileController::class, 'update'] )->name( 'profile.update' );
    Route::delete( '/profile', [ProfileController::class, 'destroy'] )->name( 'profile.destroy' );
} );

Route::resource( 'product', ProductController::class );
Route::post( 'product/{product}', [ProductController::class, 'update'] )->name( 'products.update' );

require __DIR__ . '/auth.php';