<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Listeners;

use App\Addons\Fund\DTO\AddFundDTO;
use App\Events\Core\Invoice\InvoiceCompleted;

class AddFundInvoiceCompletedListener
{
    public function handle(InvoiceCompleted $event)
    {
        $invoice = $event->invoice;
        foreach ($invoice->items as $item) {
            if ($item->type == AddFundDTO::ADD_FUND_TYPE) {
                $item->relatedType()->addFund($item);
                $item->delivered_at = date('Y-m-d H:i:s');
                $item->save();
            }
        }
    }
}
