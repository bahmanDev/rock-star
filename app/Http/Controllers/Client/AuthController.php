<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected UserRepository $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token)
            return ResponseData::error(message: 'Unauthorized', status: 401);

        $user = Auth::user();
        return ResponseData::success(data: [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(RegisterRequest $request){

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return ResponseData::success(message: 'User created successfully', data: [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return ResponseData::success('Successfully logged out');
    }

    public function refresh()
    {
        return ResponseData::success(data: [
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
