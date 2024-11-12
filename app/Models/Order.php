<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = "order";

    protected $fillable = [
        "user_id",
        "order_no",
        "payment_method",
        "order_status",
        "total_price",
        "tax_total_price",
        "total_qty",
        "name",
        "company",
        "address",
        "email",
        "phone",
        "notes",
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItems::class, "order_id", "id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
