<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
