<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\OrderDto;
use App\Exceptions\OrderCreationException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartService {

    public Cart $cart;

    public function __construct() {
        $this->cart = Cart::fromSession();
    }

    public static function regenerateSessionId(): string {
        $sessionId = Str::random(100);

        return $sessionId;
    }

    public function items(): Collection {
        return $this->cart->items;
    }

    public function removeItem(int $id): bool {
        try {
            $item = CartItem::findOrFail($id);

            if($this->cart->hasItem($item->id)) {
                return $item->delete();
            }
        } catch (\Throwable $th) {
            return false;
            Log::info($th->getMessage());
        }
    }

    public function addCartItem(array $data): CartItem {
        if($item = $this->cart->hasItem($data['product_id'])) {
            return $this->cart->addQuantity($item, $data['quantity']);
        } else {
            $data['cart_id'] = $this->cart->id;

            return $this->cart->addItem($data);
        }
    }

    public function convertCartToOrder(OrderDto $orderDto): Order {
        $cart = $this->cart;
        $totalPrice = $cart->getTotalPrice();

        $orderData = $orderDto->toArray();
        $orderData['cart_id'] = $this->cart->id;
        $orderData['total_price'] = $totalPrice;

        try {
            return DB::transaction(function() use($orderData, $cart) {
                $order = Order::create($orderData);

                if($order) {
                    foreach($cart->items as $cartItem) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->name = $cartItem->product->name;
                        $orderItem->product_id = $cartItem['product_id'];
                        $orderItem->quantity = $cartItem['quantity'];
                        $orderItem->price = $cartItem->product->getItemPrice();

                        $orderItem->save();
                    }
                }

                $cart->status = 1;
                $cart->save();

                return $order;
            });

        } catch (\Throwable $th) {
            throw new OrderCreationException('Hiba történt a rendelés leadása közben!');
            Log::error($th->getMessage());
        }
    }
}