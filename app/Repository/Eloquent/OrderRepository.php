<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface {
    public function list(int $limit, int $page = 1): Collection
    {
        $skip = ($page - 1) * $limit;

        return Order::skip($skip)->take($limit)->get();
    }

    public function findById(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function findAllByUserId(int $userId): Collection
    {
        return Order::whereUserId($userId)->get();
    }

    public function delete(int $id): bool
    {
        $order = Order::findOrFail($id);

        return $order->delete();
    }
}