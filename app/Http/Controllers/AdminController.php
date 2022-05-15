<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if(!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return response( )->json('Hibás felhasználónév vagy jelszó', Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user('admin')->createToken('token')->plainTextToken;

        $cookie = cookie('admin-jwt', $token, 60 * 24);

        return response()->json($request->user('admin'))->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = Cookie::forget('admin-jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
