<?php

namespace App\Fund;

use App\Auth\User;
use ClientX\Database\Query;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class FundCustomerItem implements NavigationItemInterface
{
    private User $user;
    /**
     * @var \App\Fund\FundService
     */
    private FundService $service;

    public function __construct(FundService $service)
    {
        $this->service = $service;
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): int
    {
        return 80;
    }

    /**
     * @inheritDoc
     */
    public function render(RendererInterface $renderer): string
    {
        $transferts = $this->service->findForUser($this->user->getId());

        $addMoney = (new Query($this->service->getTransferTable()->getConnection()))
            ->setCommand("SELECT")
            ->into(\stdClass::class)
            ->from("fund_transactions")
            ->where("user_id = :user_id")
            ->params(['user_id' => $this->service->getUserId()])
            ->fetchAll();
        $user = $this->user;
        return $renderer->render('@fund_admin/user', compact('transferts', 'addMoney', 'user'));
    }


    public function setUser(User $user)
    {
        $this->user = $user;
    }
}