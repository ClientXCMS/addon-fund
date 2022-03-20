<?php

namespace App\Fund\Actions;

use ClientX\Actions\Payment\PaymentCancelAction;

class FundCancelAction extends PaymentCancelAction
{
    protected string $success = "serviceactions.transactions.cancel";
    protected string $returnRoute = "fund.index";

}