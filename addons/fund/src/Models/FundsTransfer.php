<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Models;

use App\Models\Account\Customer;

class FundsTransfer extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'funds_transfers';

    protected $fillable = ['customer_id', 'recipient_id', 'amount', 'currency', 'status', 'transferred_at', 'transferable_at'];

    protected $casts = [
        'transferred_at' => 'datetime',
        'transferable_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Customer::class, 'recipient_id');
    }

    public function makeTransfer()
    {
        if ($this->amount > $this->customer->balance) {
            $this->status = 'failed';
            $this->save();

            return false;
        }
        $this->status = 'completed';
        $this->transferred_at = now();
        $this->save();
        $this->customer->addFund(-$this->amount);
        $this->recipient->addFund($this->amount);

        return true;
    }

    public function cancel()
    {
        $this->status = 'canceled';
        $this->save();
    }
}
