<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\OrderDto;
use App\Facades\Cart;
use App\Http\Resources\OrderResource;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function list(Request $request): JsonResponse {
        $limit = (int) getenv('ORDER_PAGE_LIMIT');

        $orders = $this->orderRepository->list($limit, (int) $request->query('page'));

        return response()->json(OrderResource::collection($orders));
    }

    public function create(Request $request): JsonResponse {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $order = Cart::convertCartToOrder(OrderDto::fromRequest($request->all()));
        $newSession = Cart::regenerateSessionId();
        $cookie = cookie('cart_session_id', $newSession, 3600 * 24 * 31);

        return response()->json($order)->withCookie($cookie);
    }

    public function findById(int $id): JsonResponse {
        return response()->json(new OrderResource($this->orderRepository->findById($id)));
    }

    public function delete(int $id): JsonResponse
    {
        return response()->json($this->orderRepository->delete($id));
    }
}
