<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
use App\Addons\Fund\Http\Controllers\FundAdminController;

Route::put('settings', [FundAdminController::class, 'saveSettings'])->name('settings');
