<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;

class ChangePasswordController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return $this->sendError("Not Used");
    }
    public function create(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
    public function store(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
    public function show(Request $request) : JsonResponse
    {
        return $this->sendError("Not Used");
    }

    public function edit() : JsonResponse
    {
        return $this->sendError("Not Used");
    }
    /**
     * Make an changePassword for a specified User.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/changePassword/{id}",
     *      operationId="changePassword",
     *      tags={"changePassword"},
     *      summary="Update password for a specified User",
     *      description="Returns the User with changed password",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id from the current User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="lastPassword",
     *         in="query",
     *         description="lastPassword from the current User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password from the current User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="confirmPassword",
     *         in="query",
     *         description="confirmPassword from the current User",
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
     *
     * Returns the User with changed password
     */
    public function update(Request $request) : JsonResponse
    {
        $request->validate([
            'lastPassword' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required'
        ]);
        var_dump(Auth::user()->getAuthPassword());
        if(Hash::check($request->get('lastPassword'), Auth::user()->getAuthPassword())) {
            if ($request->get('password') == $request->get('confirmPassword')) {
                Auth::user()->update(['password'=> Hash::make($request->get('password'))]);
                return $this->sendResponse(Auth::user(), "Password changed successfully");
            } else {
                return $this->sendError("New password doesn't match with confirmation");
            }
        }
        else{
            return $this->sendError("Password doesn't match");
        }
    }

    public function destroy(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
}
