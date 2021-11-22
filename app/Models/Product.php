<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public function creatives(): BelongsTo
    {
        return $this->belongsTo(Creative::class, "creative_id");
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, "product_type_id");
    }
}
