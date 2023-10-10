<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        DB::beginTransaction();
        try {

            $token = VerificationToken::validToken()->where('token', $request->get('token'))
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $token->is_used = true;
            $token->save();
            User::where('id', auth()->id())->update([
                'email_verified_at' => now()
            ]);

            DB::commit();
            return response()->json([
                'status' => 'Email verified successfully'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => 'Invalid verification token',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
