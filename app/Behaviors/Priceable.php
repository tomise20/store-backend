<?php

declare(strict_types=1);

namespace App\Behaviors;

trait Priceable {

    public function getTotalPrice()
    {
        $model = $this;
        $items = $model->items;
        $price = 0;

        foreach ($items as $item) {
            $price += intval($item->product->getItemPrice() * $item->quantity);
        }

        $price < 0 ? 0 : $price;

        return $price;
    }

    public function getTotalQuantity($model)
    {
        $model = $this;
        $items = $model->items;
        $qt = 0;

        foreach ($items as $value) {
            $qt = $qt + $value->quantity;
        }

        return $qt;
    }
}