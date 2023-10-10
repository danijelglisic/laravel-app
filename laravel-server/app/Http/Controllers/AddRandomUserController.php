<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class AddRandomUserController extends Controller
{
    public function __invoke()
    {
        $user = User::create([
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
            'phone_number' => fake()->phoneNumber(),
        ]);

        return new UserResource($user);
    }
}
