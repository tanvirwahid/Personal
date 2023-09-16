<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate(
            [
                'email' => 'required|exists:users',
                'password' => 'required',
            ]
        );

        try {
            $isAuthenticatedUser = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if (! $isAuthenticatedUser) {
                return response()->json(
                    [
                        'email' => [
                            'Wrong credentials. Try with correct login credentials.',
                        ],
                    ],
                    Response::HTTP_UNAUTHORIZED);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }
}
