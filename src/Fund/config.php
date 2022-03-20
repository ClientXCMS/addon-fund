<?php

use ClientX\Navigation\DefaultMainItem;

return [
    'navigation.main.items' => \DI\add(new DefaultMainItem([DefaultMainItem::makeItem("fund.add", "fund.index", "fas fa-dollar", false, true)], 90)),
    'fundconfig.max' => \ClientX\setting('max_fund', 50),
    'fundconfig.min' => \ClientX\setting('min_fund', 1),
    'fundconfig.maxtransfer' => \ClientX\setting('maxtransfer_fund', 50),
    'fundconfig.mintransfer' => \ClientX\setting('mintransfer_fund', 1)
];