<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    public $fillable = ['cart_id', 'product_id', 'quantity', 'price'];

    public $timestamps = false;

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

}
