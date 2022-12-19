<?php

namespace App\Fund;

use App\Fund\FundService;

class FundSchedule extends \ClientX\Cron\AbstractCron
{
    protected $name = "fund";
    protected $title = "Auto Fund";
    protected $icon = "fas fa-filter-circle-dollar";
    public $time = 3600;
    private FundService $service;

    public function __construct(FundService $service)
    {
        $this->service = $service;
    }

    public function run(): array
    {
        $tmp = $this->service->makeTransfers();
        if (empty($tmp)){
            return [];
        }
        return ["fund" => $tmp];
    }
}