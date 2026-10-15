<?php

namespace App\Models;

class ProductCategory extends Category
{
    /**
     * ProductCategory serves as the product-category alias required by the
     * assignment while sharing the existing categories table and logic.
     */
    protected $table = 'categories';
}
