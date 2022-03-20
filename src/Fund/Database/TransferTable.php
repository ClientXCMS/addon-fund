<?php

namespace App\Fund\Database;

use Carbon\Carbon;

class TransferTable extends \ClientX\Database\Table
{
    protected $table = "fund_transfers";
    protected $entity = \stdClass::class;

    public function addTransfer(int $userId, int $recipientId, float $amount)
    {
        $this->insert([
            'user_id' => $userId,
            'recipient_id' => $recipientId,
            'state' => 'Pending',
            'mustbesentat' => Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s'),
            'amount' => $amount
        ]);
    }

    public function accept(int $id)
    {
        $this->update($id, ['state' => 'Accepted']);
    }


    public function cancel(int $id)
    {
        $this->update($id, ['state' => 'Cancelled']);
    }

    public function fetchTransfers(?int $userId = null)
    {
        $query = $this->makeQuery()
            ->where("mustbesentat < NOW()")
            ->where('state = :state')
            ->setParameter('state', 'Pending');
        if ($userId) {
            $query->where('user_id = :userId')
                ->setParameter('userId', $userId);
        }
        return $query->fetchAll();
    }
}
