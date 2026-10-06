<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'address',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'integer',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getOrderNumberAttribute(): string
    {
        return '#USEA-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }
}
