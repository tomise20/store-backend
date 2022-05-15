<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enum\OrderStatus;
use Illuminate\Contracts\Support\Arrayable;

class OrderDto implements Arrayable {

    private ?int $userId;
    private string $email;
    private string $name;
    private string $address;
    private OrderStatus $status;

    public static function fromRequest(array $data): self {
        $order = new self();

        $order->userId = $data['user_id'] ?? null;
        $order->email = $data['email'];
        $order->name = $data['name'];
        $order->address = $data['address'];
        $order->status = OrderStatus::RECEIVED;

        return $order;
    }

    public function toArray(): array {
        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'status' => $this->status
        ];
    }
}