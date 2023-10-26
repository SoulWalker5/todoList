<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\LoginDTO;
use App\Exceptions\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginService $loginService): JsonResponse|Arrayable
    {
        try {
            $token = $loginService->login(new LoginDTO(...$request->validated()));
        } catch (LoginException $e) {
            return new JsonResponse(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $token;
    }
}
