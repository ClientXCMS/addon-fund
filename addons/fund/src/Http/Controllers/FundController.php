<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Http\Controllers;

use App\Addons\Fund\DTO\AddFundDTO;
use App\Exceptions\WrongPaymentException;
use App\Models\Billing\Gateway;
use Illuminate\Http\Request;

class FundController extends \App\Http\Controllers\Controller
{
    public function addFund(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:'.setting('fund_credit_min_amount', 5).'|max:'.setting('fund_credit_max_amount', 1000),
            'gateway' => 'required|exists:gateways,uuid',
        ]);
        /** @var Gateway $gateway */
        $gateway = Gateway::where('uuid', $validated['gateway'])->first();

        if ($gateway->minimal_amount > $validated['amount']) {
            return back()->with('error', __('store.checkout.minimal_amount', ['amount' => formatted_price($gateway->minimal_amount)]));
        }
        $invoice = AddFundDTO::createInvoice($validated);
        try {
            return $invoice->pay($gateway, $request);
        } catch (WrongPaymentException $e) {
            logger()->error($e->getMessage());
            $message = __('store.checkout.wrong_payment');
            if (auth('admin')->check()) {
                $message .= ' Debug admin : '.$e->getMessage();
            }

            return back()->with('error', $message);
        }
    }

    public function createTransfer(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|exists:customers,email',
            'amount' => 'required|numeric|min:'.setting('fund_transfer_min_amount', 1).'|max:'.setting('fund_transfer_max_amount', 1000),
        ]);
        try {
            $transfer = AddFundDTO::createTransfer($validated['recipient'], $validated['amount']);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', __('fund::messages.transfer.success', ['minutes' => setting('fund_transfer_minutes_delay', 5)]));
    }

    public function cancel(\App\Addons\Fund\Models\FundsTransfer $transfer)
    {
        if (! auth('web')->check()) {
            abort(404);
        }
        if (auth('web')->check() && $transfer->customer_id != auth('web')->id()) {
            abort(404);
        }
        if (auth('admin')->check() && $transfer->status != 'pending') {
            abort(404);
        }
        $transfer->cancel();

        return redirect()->back()->with('success', __('fund::messages.transfer.cancel'));
    }
}
