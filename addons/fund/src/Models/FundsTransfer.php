<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */

namespace App\Addons\Fund\Models;

use App\Models\Account\Customer;

/**
 * 
 *
 * @property int $id
 * @property int $customer_id
 * @property int $recipient_id
 * @property string $amount
 * @property string $currency
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $transferred_at
 * @property \Illuminate\Support\Carbon|null $transferable_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Customer $customer
 * @property-read Customer $recipient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereTransferableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereTransferredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FundsTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        $this->customer->addFund(-$this->amount, 'Transfer to ' . $this->recipient->name);
        $this->recipient->addFund($this->amount, 'Transfer from ' . $this->customer->name);

        return true;
    }

    public function cancel()
    {
        $this->status = 'canceled';
        $this->save();
    }
}
