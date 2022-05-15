<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface {
    public function list(int $limit, int $page = 1): Collection;

    public function findById(int $id): Product;

    public function findAllByName(int $limit, ?string $name = null, ?int $page = 1): Collection;

    public function count(?string $filter = null): int;
}