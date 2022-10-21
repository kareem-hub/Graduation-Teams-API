<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
// use App\Traits\HttpResponses;
// use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        // check if there was a successful login attempt
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credintials do not match any record', 401);
        }

        $user = User::where('email', $request->email)
            ->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Token of ' . $user->name)->plainTextToken
        ]);


        return response()->json('this is login');
    }

    public function register(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Auth token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'Logged out successfully'
        ]);
    }
}
