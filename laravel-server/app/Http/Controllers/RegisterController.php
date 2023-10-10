<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationEmail;
use Illuminate\Http\Response;
use PHPUnit\Exception;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): RegisterResource|JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            Mail::to($user->email)->send(new ConfirmationEmail($user->generateToken()));
            DB::commit();
            return new RegisterResource($user);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Invalid verification token',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function resendToken(): JsonResponse
    {
        Mail::to(request()->user()->email)->send(new ConfirmationEmail(request()->user()->generateToken()));
        return response()->json([
            'message' => 'New code is send.'
        ]);
    }

}
