<?php

use App\Fund\FundSchedule;
use App\Fund\FundCustomerItem;
use App\Fund\FundNavigation;
use ClientX\Navigation\DefaultMainItem;

use function ClientX\setting;
use function DI\add;
use function DI\autowire;
use function DI\get;

return [
    'navigation.main.items' => add(new DefaultMainItem([DefaultMainItem::makeItem("fund.add", "fund.index", "fas fa-dollar", false, true)], 90)),
    'fundconfig.max' => setting('max_fund', 50),
    'fundconfig.min' => setting('min_fund', 1),
    'fundconfig.maxtransfer' => setting('maxtransfer_fund', 50),
    'fundconfig.mintransfer' => setting('mintransfer_fund', 1),
    'addfund.types' => add([]),
    FundNavigation::class   => autowire()->constructor(get('addfund.types')),
    'navigation.list' => add(get(FundNavigation::class)),
    'cron.schedules' => add(FundSchedule::class),
    'admin.customer.items' => add(get(FundCustomerItem::class)),

];