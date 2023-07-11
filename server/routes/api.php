<?php

// use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\Public;
use App\Http\Controllers\Api\V1\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::apiResource('events', Public\EventController::class)->only(['index', 'show']);
Route::get('events/{event:slug}/tickets', [Public\EventController::class, 'ticketsByEvent']);
Route::apiResource('feedbacks', Public\FeedbackController::class)->only(['store']);


Route::post('register', Auth\RegisterController::class);
Route::post('login', Auth\LoginController::class);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('password-reset', Auth\PasswordResetController::class);
    Route::post('logout', Auth\LogoutController::class);


    Route::prefix('super-admin')->middleware(['role:super-admin'])->group(function () {
        Route::apiResource('countries', Admin\CountryController::class);
        Route::apiResource('currencies', Admin\CurrencyController::class);
        Route::apiResource('events', Admin\EventController::class);
        Route::apiResource('event-halls', Admin\EventHallController::class);
        Route::apiResource('feedbacks', Admin\FeedbackController::class)->except(['update']);
        Route::apiResource('hosts', Admin\HostController::class);
        Route::apiResource('newsletters', Admin\NewsletterController::class);
        Route::apiResource('tags', Admin\TagController::class);
        Route::apiResource('tickets', Admin\TicketController::class);
        Route::apiResource('ticket-types', Admin\TicketTypeController::class);
        Route::apiResource('ticket-verifications', Admin\TicketVerificationController::class);
        Route::apiResource('users', Admin\UserController::class);
    });


    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::apiResource('events', Admin\EventController::class)->only(['index', 'show']);
        Route::get('events/{event:slug}/tickets', [Admin\EventController::class, 'ticketsByEvent']);
        Route::apiResource('tickets', Admin\TicketController::class)->except(['update', 'destroy']);
        Route::apiResource('ticket-verifications', Admin\TicketVerificationController::class)->except(['update', 'destroy']);
    });


    // Route::prefix('admin')->group(function () {
    //     Route::middleware(['role:super-admin|admin'])->group(function () {
    //         Route::apiResource('events', Admin\EventController::class)->only(['index', 'show']);
    //         Route::get('events/{event:slug}/tickets', [Admin\EventController::class, 'ticketsByEvent']);
    //         Route::apiResource('tickets', Admin\TicketController::class)->except(['update', 'destroy']);
    //         Route::apiResource('ticket-verifications', Admin\TicketVerificationController::class);
    //     });

    //     Route::middleware(['role:super-admin'])->group(function () {
    //         Route::apiResource('countries', Admin\CountryController::class);
    //         Route::apiResource('currencies', Admin\CurrencyController::class);
    //         Route::apiResource('events', Admin\EventController::class);
    //         Route::apiResource('event-halls', Admin\EventHallController::class);
    //         Route::apiResource('feedbacks', Admin\FeedbackController::class)->except(['update']);
    //         Route::apiResource('hosts', Admin\HostController::class);
    //         Route::apiResource('newsletters', Admin\NewsletterController::class);
    //         Route::apiResource('tags', Admin\TagController::class);
    //         Route::apiResource('tickets', Admin\TicketController::class);
    //         Route::apiResource('ticket-types', Admin\TicketTypeController::class);
    //         Route::apiResource('ticket-verifications', Admin\TicketVerificationController::class);
    //         Route::apiResource('users', Admin\UserController::class);
    //     });
    // });


    Route::prefix('user')->middleware(['role:generic-user'])->group(function () {
        Route::apiResource('events', User\EventController::class)->only(['index', 'show']);
        Route::get('events/{event:slug}/tickets', [User\EventController::class, 'ticketsByEvent']);
        Route::apiResource('tickets', User\TicketController::class)->except(['update']);
        Route::apiResource('feedbacks', User\FeedbackController::class)->except(['update']);
    });
});
