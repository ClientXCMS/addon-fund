<?php

namespace App\Fund;

use App\Shop\Entity\Orderable;
use App\Shop\Entity\Recurring;
use DateTime;

class AddFund implements Orderable
{
    public int $id;
    public float $amount;
    public int $userId;
    public string $currency;

    public function __construct(?float $amount=null, ?int $userId=null, ?string $currency=null, ?int $id=null)
    {
		if ($amount){
            $this->amount = $amount;
            $this->userId = $userId;
            $this->currency = $currency;
            $this->id = $id;
	    }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return "Ajout de " . $this->amount . ' ' . $this->currency;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getPrice(string $recurring = Recurring::MONTHLY, bool $setup = false, array $options = [])
    {
        if ($setup) {
            return 0;
        }
        return $this->amount;
    }

    public function inStock(): bool
    {
        return true;
    }

    public function getRecurring(): Recurring
    {
        return Recurring::onetime();
    }

    public function getPaymentType(): string
    {
        return "onetime";
    }

    public function hasAutoterminate(): bool
    {
        return false;
    }

    public function canRecurring(): bool
    {
        return false;
    }

    public function getAutoTerminateAt(): ?DateTime
    {
        return null;
    }

    public function getExpireAt(): ?DateTime
    {
        return null;
    }

    public function getTable(): string
    {
        return "fund_transactions";
    }

    public function getType(): string
    {
        return "fund_transactions";
    }
}
