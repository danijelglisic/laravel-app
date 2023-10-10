<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Exception;

class ForgotPasswordController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'email' => ['required', 'email', 'exists:users,email']
            ]);

            $user = User::where('email', $request->get('email'))->firstOrFail();
            Mail::to($user->email)->send(new ResetPasswordMail($user->generateToken()));

            DB::commit();

            return response()->json([
                'message' => 'Reset password code sent to your email.'
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Email is not sent to your adress',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(ForgotPasswordRequest $request, string $token): JsonResponse
    {
        $data = $request->validated();

        VerificationToken::validToken()->where('token', $token)->firstOrFail();

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make($data['password']);
        $user->update();

        return response()->json(['success' => 'Password successfully changed!']);
    }


}
