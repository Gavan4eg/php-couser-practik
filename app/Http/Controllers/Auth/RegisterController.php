<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class RegisterController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function sendSms(RegisterRequest $request): View|RedirectResponse
    {
        $data = $request->validated();

        $user = User::query()
            ->where('phone', $data['phone'])
            ->first();

        if ($user) {
            return redirect()
                ->back()
                ->with('error', 'Пользователь с таким номером телефона уже существует.');
        }

        $this->authService->initializeUserVerification($data['phone'], $data['name']);

        return view('auth.verify-sms');
    }
}
