<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface {
    public function list(int $limit, int $page = 1): Collection;

    public function findById(int $id): Order;

    public function findAllByUserId(int $userId): Collection;

    public function delete(int $id): bool;
}