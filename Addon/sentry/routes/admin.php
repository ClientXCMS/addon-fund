<?php
Route::put('sentry', [\App\Addons\Sentry\Controllers\SentryController::class, 'store'])->name('settings');
