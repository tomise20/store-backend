<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\OrderResource;
use App\Repository\OrderRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(UserRepositoryInterface $userRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);
        $user = $this->userRepository->create($request->all());

        Auth::login($user);

        $token = $request->user()->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json($user)->withCookie($cookie);
    }

    public function login(Request $request): JsonResponse
    {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response( )->json('Hibás felhasználónév vagy jelszó!', Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json($request->user())->withCookie($cookie);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

     public function findAllForUser(Request $request): JsonResponse {
        return response()->json(OrderResource::collection($this->orderRepository->findAllByUserId($request->user()->id)));
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
