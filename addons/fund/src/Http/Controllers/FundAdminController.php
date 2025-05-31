<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Http\Controllers;

use App\Models\Admin\Setting;
use Illuminate\Http\Request;

class FundAdminController
{
    public function settings()
    {
        return view('fund_admin::settings');
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'fund_credit_min_amount' => 'required|numeric:min:1',
            'fund_credit_max_amount' => 'required|numeric:min:'.(int) $request->fund_credit_min_amount,
            'fund_transfer_min_amount' => 'required|numeric:min:1',
            'fund_transfer_max_amount' => 'required|numeric:min:'.(int) $request->fund_transfer_min_amount,
            'fund_authorize_transfer_between_accounts' => 'in:true,false',
            'fund_transfer_minutes_delay' => 'required|numeric:min:1',
            'fund_transfer_min_invoice' => 'required|numeric:min:0',
        ]);
        $validated['fund_authorize_transfer_between_accounts'] = $validated['fund_authorize_transfer_between_accounts'] ?? false;
        Setting::updateSettings($validated);

        return back()->with('success', __('fund::messages.admin.settings.success'));
    }

    public function transfers()
    {
        $items = \App\Addons\Fund\Models\FundsTransfer::paginate(10);

        return view('fund_admin::transfers', compact('items'));
    }
}
