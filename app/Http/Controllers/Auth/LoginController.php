<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): View
    {
        return view('auth.login');
    }

    public function sendSmsAuth(RegisterRequest $request): View|RedirectResponse
    {
        $data = $request->validated();


        $user = User::query()
            ->where('phone', $data['phone'])
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователя нет в базе');
        }

        $this->authService->initializeUserVerification($data['phone'], $user['name']);

        return view('auth.verify-sms');
    }

}
