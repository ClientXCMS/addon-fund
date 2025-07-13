<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
Route::post('add_fund', [\App\Addons\Fund\Http\Controllers\FundController::class, 'addFund'])->name('add_fund');
Route::post('create_transfer', [\App\Addons\Fund\Http\Controllers\FundController::class, 'createTransfer'])->name('create_transfer')->middleware('throttle:6,1');;
Route::delete('cancel_transfer/{transfer}', [\App\Addons\Fund\Http\Controllers\FundController::class, 'cancel'])->name('cancel_transfer');
