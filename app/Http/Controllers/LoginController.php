<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends UserController
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            "email" => 'required',
            "password" => 'required',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token'] =  $user->createToken('ApiToken', ['server:update'])->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');

        }
        else
        {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function register (Request $request): array
    {
        return $this->store($request);
    }
}
