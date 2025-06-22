<?php

namespace App\Http\Controllers;

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
    
// ----------------------- public page route section ----------------------- //
Route::get('/', [PublicPageController::class, 'index']);
Route::get('/posts', [PublicPageController::class, 'posts']);
Route::get('/posts/{slug}', [PublicPageController::class, 'post_details']);
Route::get('/about-us', [PublicPageController::class, 'about_us']);
Route::get('/contact-us', [PublicPageController::class, 'contact_us']);
Route::get('/faq', [PublicPageController::class, 'faq']);
Route::get('/privacy-policy', [PublicPageController::class, 'privacy_policy']);
Route::get('/terms-and-conditions', [PublicPageController::class, 'terms_and_conditions']);

// ----------------------- ADMIN panel route section ----------------------- //
Route::middleware('auth')->group(function() {
    Route::prefix('admin-panel')->group(function() {
        Route::get('/dashboard', [AdminPanel\DashboardController::class, 'index']);

        Route::resource('categories', AdminPanel\CategoryController::class);
        Route::resource('posts', AdminPanel\PostController::class);

        Route::get('/my-account', [AdminPanel\MyAccountController::class, 'my_account']);
        Route::get('/my-account-edit', [AdminPanel\MyAccountController::class, 'my_account_edit']);
        Route::put('/my-account-update', [AdminPanel\MyAccountController::class, 'my_account_update']);
        Route::get('/change-theme-color', [AdminPanel\MyAccountController::class, 'change_theme_color']);
    });
});

// ----------------------- CLIENT panel route section ----------------------- //
// Route::prefix('client-panel')->group(function() {
//     Route::get('/login', [Auth\ClientAuthenticationController::class, 'login']);
//     Route::post('/login', [Auth\ClientAuthenticationController::class, 'login_store']);
//     Route::get('/registration', [Auth\ClientAuthenticationController::class, 'registration']);
//     Route::post('/registration', [Auth\ClientAuthenticationController::class, 'registration_store']);

//     Route::middleware('auth:client')->group(function() {
//         Route::get('/dashboard', [ClientPanel\DashboardController::class, 'index']);

//         Route::get('/my-account', [ClientPanel\MyAccountController::class, 'my_account']);
//         Route::get('/my-account-edit', [ClientPanel\MyAccountController::class, 'my_account_edit']);
//         Route::put('/my-account-update', [ClientPanel\MyAccountController::class, 'my_account_update']);
//     });
// });

require __DIR__.'/auth.php';
