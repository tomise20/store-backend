<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface {

    public function list(int $limit, int $page = 1): Collection {
        $skip = ($page - 1) * $limit;

        return Product::whereAvailable(true)->skip($skip)->take($limit)->get();
    }

    public function findById(int $id): Product {
        return Product::findOrFail($id);
    }

    public function findAllByName(int $limit, ?string $name = null, ?int $page = 1): Collection {
        $name = strtolower($name);
        $skip = ($page - 1) * $limit;

        return Product::whereAvailable(true)->whereRaw('lower(name) like (?)', ["%$name%"])->skip($skip)->take($limit)->get();
    }

    public function count(?string $filter = null): int
    {
        return Product::whereAvailable(true)->whereRaw('lower(name) like (?)', ["%$filter%"])->count();
    }
}