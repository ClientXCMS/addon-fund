<?php
namespace App\Fund;

use ClientX\Navigation\NavigationInterface;

class FundNavigation implements NavigationInterface {

    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }
    /**
     * Exemple : Menu
     *
     * @return string;
     */
    public function getType():string
    {
        return "fund";
    }
    /**
     *
     * @return NavigationItemInterface[]
     */
    public function getItems():array{
        return $this->items;
    }

    /**
     * @return bool
     */
    public function useUser():bool{
        return false;
    }
}