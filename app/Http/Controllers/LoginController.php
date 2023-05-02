<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends UserController
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"Login"},
     *      summary="Log into API",
     *      description="Returns token with User Infos",
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password of the user",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     * Returns the registred user
     */
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
            $success['id'] =  $user->id;

            return $this->sendResponse($success, 'User login successfully.');

        }
        else
        {
            return $this->sendError('Not Found.', ['error'=>'User not found'], 401);
        }
    }
    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="register",
     *      tags={"Login"},
     *      summary="Register into API",
     *      description="Returns token with User Infos",
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="Lastname of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="age",
     *         in="query",
     *         description="Age of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="phoneNumber",
     *         in="query",
     *         description="Phone Number of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Gender of the user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="City of the user",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     * Returns the registred user
     */
    public function register (Request $request): JsonResponse
    {
        return $this->store($request);
    }
}
