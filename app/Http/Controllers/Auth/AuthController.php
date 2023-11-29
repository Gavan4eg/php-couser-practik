<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function verifySms(Request $request): RedirectResponse|JsonResponse
    {
        $phone = session('phone');
        $name = session('name');
        $code = $request->get('code');

        $isValidCode = $this->authService->validateVerificationCode($phone, $code);

        $user = User::query()->where('phone', $phone)->first();

        if ($isValidCode) {
            if (!$user) {
                $this->authService->createUser($phone, $name);
            }

            $this->authService->authUser($phone);

            return redirect()->route('front.index');
        } else {
            return response()->json(['message' => 'Неверный код подтверждения'], 401);
        }
    }
}
