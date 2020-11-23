<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $status
 * @property string $description
 * @property string $paid_at
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice[] $invoices
 * @property OrderItem[] $items
 * @property Payment[] $payments
 * @property Shipping $shippings
 */
class Order extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'status', 'description', 'paid_at', 'created_at', 'updated_at'];

    protected $appends = [
        'total_amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shippings()
    {
        return $this->hasOne('App\Models\Shipping');
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum('price');
    }
}
