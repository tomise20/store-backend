<?php

declare(strict_types=1);

namespace App\Models;

use App\Behaviors\Priceable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory, Priceable;

    public $fillable = ['session_id', 'status'];

    protected $hidden = ['session_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public static function fromSession(): self
    {
        $sessionId = self::getSessionId();

        $cart = self::orderBy('created_at', 'DESC')->where('status', 0)->where('session_id', $sessionId)->first();
        if (!$cart) {
            $cart = Cart::create(['session_id' =>  $sessionId]);
        }

        return $cart;
    }

    private static function getSessionId(): string
    {
        $sessionId = Cookie::get('cart_session_id') ?? Str::random(100);

        return $sessionId;
    }

    public function addItem(array $cartItem): CartItem
    {
        return CartItem::create($cartItem);
    }

    public function addQuantity(CartItem $item, int $qty): CartItem
    {
        $qty = intval($item->quantity) + $qty;
        $item->update(['quantity' => $qty]);

        return $item;
    }

    public function hasItem(int $productId): ?CartItem
    {
        return $this->items->first(fn(CartItem $item) => $item->product_id === $productId);
    }
}
