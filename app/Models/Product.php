<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'original_price',
        'discount_percentage',
        'is_promo',
        'stock',
        'category',
        'category_id',
        'image',
        'seller_name',
        'location',
        'rating',
        'clicks',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'original_price' => 'integer',
            'discount_percentage' => 'integer',
            'is_promo' => 'boolean',
            'stock' => 'integer',
            'clicks' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Keep the string category column and the category_id foreign key in sync
     * so existing UI, filters, forms, cart and checkout continue to work.
     */
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            // When category_id is explicitly set, make the string column match it.
            if ($product->isDirty('category_id') && $product->category_id) {
                $product->category = Category::find($product->category_id)?->name ?? $product->category;

                return;
            }

            // Otherwise keep the relationship in sync with the string category value.
            if ($product->isDirty('category') && $product->category) {
                $category = Category::firstOrCreate(['name' => $product->category]);
                $product->category_id = $category->id;
            }
        });
    }
}
