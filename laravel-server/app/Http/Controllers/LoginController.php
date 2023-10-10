<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): LoginResource|JsonResponse
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();


        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new LoginResource($user->createToken(Str::random()));
    }
}

