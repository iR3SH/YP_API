<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Mockery\Matcher\HasKey;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index() : array
    {
        $user = User::latest()->paginate(10);
        return [
            "status" => 1,
            "data" => $user
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request) : array
    {
        $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required|unique:users',
            'gender' => 'required',
            'city' => 'required',
        ]);
        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->get('password'));
        $user = User::create($inputs);
        $token =  $user->createToken('MyApp')->plainTextToken;
        return [
            'status' => 1,
            "data" => $user,
            "token" => $token,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return array
     */
    public function show(User $user) : array
    {
        return [
            "status" => 1,
            "data" => $user
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function update(Request $request, User $user) : array
    {
        $request->validate([
            'email' => 'required|unique:users',
            'phoneNumber' => 'required|unique:users',
            'password' => 'required',
        ]);
        $inputs = $request->all();
        if(!Hash::check($user->getAttribute('password'), Hash::make($request->get('password')))) {
            $inputs['password'] = Hash::make($request->get('password'));
        }
        $user->update($inputs);
        return [
          "status" => 1,
          "data" => $user,
           "msg" => "User updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return array
     */
    public function destroy(User $user): array
    {
        $user->delete();
        return [
          "status" => 1,
          "data" => $user,
          "msg" => "User deleted successfully"
        ];
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     *
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */

    public function sendError($error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
