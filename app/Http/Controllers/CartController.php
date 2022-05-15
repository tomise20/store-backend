<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Facades\Cart as CartService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCart(Request $request): JsonResponse {
        $cart = Cart::fromSession();
        if(!$request->cookie('cart_session_id')) {
            $cookie = cookie('cart_session_id', $cart->session_id, 3600 * 24 * 31);

            return response()->json(new CartResource($cart))->withCookie($cookie);
        }

        return response()->json(new CartResource($cart));
    }

    public function getItems(Request $request): JsonResponse
    {
        return response()->json(['data' => CartService::items($request)]);
    }

    public function addItem(Request $request): JsonResponse
    {
        $product = $this->productRepository->findById($request->input('product_id'));
        $request->merge(['price' => $product->sale_price ?? $product->price]);

        $item = CartService::addCartItem($request->all());

        if($item) {
            return response()->json(new CartItemResource($item));
        } else {
            return response()->json(['message' => 'Hiba törént!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeItem(int $id): JsonResponse
    {
        $isSuccess = CartService::removeItem($id);

        if($isSuccess) {
            return response()->json();
        }

        return response()->json(['message' => 'Hiba törént!'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
