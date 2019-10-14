<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    public function register(StoreUserRequest $form)
    {
        return $this->respondWithToken(auth()->login($form->save()), 201);
    }

    public function login(LoginUserRequest $form)
    {
        if ($token = $form->save()) return $this->respondWithToken($token, 200);

        return response()->json(['errors' => ['loginError' => ['Please check your credentials and try again.']]], 401);
    }

    public function user()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(null, 204);
    }

    protected function respondWithToken($token, $status)
    {
        return response()->json([
            'access_token' => $token,
            'user' => auth()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], $status);
    }
}
