<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Commands;

class FundCommand extends \Illuminate\Console\Command
{
    protected $signature = 'fund:transfer';

    protected $description = 'Transfer funds between accounts';

    public function handle()
    {
        /** @var \App\Addons\Fund\Models\FundsTransfer[] $transfers */
        $transfers = \App\Addons\Fund\Models\FundsTransfer::where('status', 'pending')->where('transferable_at', '<=', now())->get();
        foreach ($transfers as $transfer) {
            if ($transfer->makeTransfer()) {
                $this->info('Transfer completed');
            } else {
                $this->info('Transfer failed');
            }
        }
    }
}
