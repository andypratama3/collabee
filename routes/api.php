<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CampaignController;
use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\HiringController;
use App\Http\Controllers\Api\V1\KolController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\XenditWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::middleware(['force.json', 'throttle:60,1'])->group(function () {
        // Auth
        Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
        Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');

        // Public
        Route::get('/kols', [KolController::class, 'index'])->name('kols.index');
        Route::get('/kols/{kolProfile}', [KolController::class, 'show'])->name('kols.show');
        Route::get('/kols/{kolProfile}/portfolio', [KolController::class, 'portfolio'])->name('kols.portfolio');
        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
        Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

        // Xendit webhook
        Route::post('/webhooks/xendit', [XenditWebhookController::class, 'handle'])
            ->name('webhooks.xendit');

        // Authenticated
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
            Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');

            // Campaigns (authenticated)
            Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
            Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
            Route::post('/campaigns/{campaign}/apply', [CampaignController::class, 'apply'])->name('campaigns.apply');

            // Hirings
            Route::get('/hirings', [HiringController::class, 'index'])->name('hirings.index');
            Route::post('/hirings', [HiringController::class, 'store'])->name('hirings.store');
            Route::post('/hirings/{hiring}/accept', [HiringController::class, 'accept'])->name('hirings.accept');
            Route::post('/hirings/{hiring}/reject', [HiringController::class, 'reject'])->name('hirings.reject');

            // Chat
            Route::get('/chat/rooms', [ChatController::class, 'rooms'])->name('chat.rooms');
            Route::get('/chat/rooms/{chatRoom}', [ChatController::class, 'messages'])->name('chat.messages');
            Route::post('/chat/rooms/{chatRoom}/messages', [ChatController::class, 'send'])->name('chat.send');

            // Notifications
            Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
            Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
        });
    });
});
