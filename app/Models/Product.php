<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['name', 'description', 'price', 'sale_price', 'stock', 'available', 'image'];

    public function getItemPrice() {
       return $this->sale_price ?? $this->price;
    }
}
