<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItems extends Model
{
    protected $fillable = [
        "order_id",
        "product_id",
        "price",
        "qty",
        "total_price",
        "tax",
        "tax_price",
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, "order_id", "id");
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
