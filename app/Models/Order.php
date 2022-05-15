<?php

declare(strict_types=1);

namespace App\Models;

use App\Behaviors\Priceable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, Priceable;

    public $fillable = ['user_id', 'email', 'name', 'address', 'total_price', 'status'];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}
