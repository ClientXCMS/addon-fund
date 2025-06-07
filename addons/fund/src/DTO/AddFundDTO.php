<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\DTO;

use App\Addons\Fund\Models\FundsTransfer;
use App\Events\Core\Invoice\InvoiceCreated;
use App\Models\Account\Customer;
use App\Models\Billing\Invoice;
use App\Models\Billing\InvoiceItem;

class AddFundDTO
{
    const ADD_FUND_TYPE = 'add_fund';

    public int $invoiceId;

    public function __construct(int $invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    public static function getMinInvoiceValue()
    {
        $invoices = auth('web')->user()->invoices;

        return collect($invoices)->reduce(function ($carry, $invoice) {
            return $carry + $invoice->items()->where('type', self::ADD_FUND_TYPE)->sum('unit_price_ht');
        }, 0);
    }

    public static function createTransfer(string $recipient, float $amount)
    {
        $recipientId = Customer::where('email', $recipient)->first();
        $minInvoiceValue = self::getMinInvoiceValue();
        if (! $recipientId) {
            throw new \Exception(__('fund::messages.transfer.recipient_not_found'));
        }
        if (FundsTransfer::where('customer_id', auth()->id())->where('recipient_id', $recipientId->id)->where('status', 'pending')->exists()) {
            throw new \Exception(__('fund::messages.transfer.already_pending'));
        }
        if ($amount > auth('web')->user()->balance) {
            throw new \Exception(__('fund::messages.transfer.not_enough_funds'));
        }
        if ($amount > setting('fund_transfer_max_amount', 1000)) {
            throw new \Exception(__('fund::messages.transfer.max_amount', ['amount' => setting('fund_transfer_max_amount', 1000)]));
        }
        if ($amount < setting('fund_transfer_min_amount', 1)) {
            throw new \Exception(__('fund::messages.transfer.min_amount', ['amount' => setting('fund_transfer_min_amount', 1)]));
        }
        if ($minInvoiceValue < setting('fund_transfer_min_invoice', 5)) {
            throw new \Exception(__('fund::messages.transfer.min_invoice', ['amount' => formatted_price(setting('fund_transfer_min_invoice', 5))]));
        }

        return FundsTransfer::create([
            'customer_id' => auth()->id(),
            'recipient_id' => $recipientId->id,
            'amount' => $amount,
            'currency' => currency(),
            'status' => 'pending',
            'transferable_at' => now()->addMinutes(setting('fund_transfer_minutes_delay', 5)),
        ]);
    }

    public function invoice()
    {
        return Invoice::find($this->invoiceId);
    }

    public function getAmount(): float
    {
        return $this->invoice()->subtotal;
    }

    public function getCurrency(): string
    {
        return $this->invoice()->currency;
    }

    public function getCustomerId(): int
    {
        return $this->invoice()->customer_id;
    }

    public function addFund(InvoiceItem $invoiceItem)
    {
        $this->invoice()->customer->addFund($invoiceItem->unit_price_ht);
    }

    public static function createInvoice(array $validated)
    {
        $amount = $validated['amount'];
        $vat = 0;
        $total = $amount + $vat;
        $days = setting('remove_pending_invoice', 0) != 0 ? setting('remove_pending_invoice') : 7;
        $invoice = Invoice::create([
            'customer_id' => auth()->id(),
            'due_date' => now()->addDays($days),
            'total' => $total,
            'subtotal' => $amount,
            'currency' => currency(),
            'setupfees' => 0,
            'tax' => $vat,
            'status' => 'pending',
            'notes' => 'Credit added to account',
            'paymethod' => $validated['gateway'],
            'invoice_number' => Invoice::generateInvoiceNumber(),
        ]);
        $invoice->items()->create([
            'invoice_id' => $invoice->id,
            'description' => 'Credit added to account',
            'name' => __('fund::messages.invoice.add_credit', ['amount' => $validated['amount']]),
            'quantity' => 1,
            'unit_price_ht' => $amount,
            'unit_price_ttc' => $total,
            'unit_setup_ht' => 0,
            'unit_setup_ttc' => 0,
            'total' => $total,
            'tax' => $vat,
            'subtotal' => $amount,
            'setupfee' => 0,
            'discount' => [],
            'type' => AddFundDTO::ADD_FUND_TYPE,
            'related_id' => $invoice->id,
            'data' => [],
        ]);
        event(new InvoiceCreated($invoice));

        return $invoice;
    }
}
