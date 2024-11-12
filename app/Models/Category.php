<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['name', 'slug', 'user_id', 'parent_id'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function parentCategory(): BelongsTo
    {
        // return $this->hasOne(Category::class, "id", "parent_id")->withDefault([
        return $this->belongsTo(Category::class, "parent_id", "id")->withDefault([
            'name' => 'Ana Kategori'
        ]);
    }

    public function childCategories(): HasMany
    {
        // return $this->hasMany(Category::class, "parent_id", "id")->with("childCategories");
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
