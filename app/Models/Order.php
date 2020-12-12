<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $store_id
 * @property string $status
 * @property integer $shipping_cost
 * @property string $description
 * @property string $paid_at
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice[] $invoices
 * @property OrderItem[] $items
 * @property Payment[] $payments
 * @property Store $store
 * @property Shipping $shipping
 */
class Order extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_SHIPPED = 'SHIPPED';
    public const STATUS_CANCELLED = 'CANCELLED';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'store_id', 'status', 'shipping_cost', 'description', 'confirmed_at', 'created_at', 'updated_at'];

    public $dates = [
        'confirmed_at'
    ];

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
    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum('price') + ($this->attributes['shipping_cost'] ?? 0);
    }
}
