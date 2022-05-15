<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['order_id', 'product_id', 'quantity', 'price', 'name'];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
