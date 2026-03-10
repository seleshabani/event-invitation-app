<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function __construct(private AuthService $service)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->service->register($request->validated());
        
        return UserResource::make($user)->additional([
            'message' => 'User registered successfully',
            'token' => $user->createToken('auth_token')->plainTextToken,
        ])->response()->setStatusCode(201);
    }
}