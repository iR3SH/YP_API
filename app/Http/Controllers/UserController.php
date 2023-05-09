<?php

namespace App\Http\Controllers;

use App\Models\Photos;
use App\Models\User;
use App\Models\UsersPreferences;
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
    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="index",
     *      tags={"User"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      security={{ "bearer_token": {} }},
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
     * Returns list of users
     */
    public function index() : JsonResponse
    {
        $user = User::all();
        return $this->sendResponse($user, "Successfully send.");
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
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/api/users",
     *      operationId="store",
     *      tags={"User"},
     *      summary="Insert a new user",
     *      description="Returns the registred user",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="Lastname for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="phoneNumber",
     *         in="query",
     *         description="PhoneNumber for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Gender for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="City for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="age",
     *         in="query",
     *         description="Age for the new User",
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
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required|unique:users',
            'gender' => 'required',
            'city' => 'required',
            "age" => 'required'
        ]);
        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->get('password'));
        $user = User::create($inputs);
        $dataUserPref = [
            'activities' => 0,
            'musicStyles' => '',
            'redFlags' => '',
            'languages' => '',
            'genderPref' => '',
            'distancePref' => '',
            'idUser' => $user->id
        ];
        $userpref = UsersPreferences::create($dataUserPref);
        $token =  $user->createToken('MyApp')->plainTextToken;

        return $this->sendResponse([$user, $userpref, $token], "User created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      operationId="show",
     *      tags={"User"},
     *      summary="Get user",
     *      description="Returns user",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the user",
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
     *  )
     * Returns user
     */
    public function show(User $user) : JsonResponse
    {
        $photos = Photos::where('idUser', $user->id)->get();
        $array = [$user, $photos];
        return $this->sendResponse($array, "User sent successfully");
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
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/users/{id}",
     *      operationId="update",
     *      tags={"User"},
     *      summary="Update one user",
     *      description="Returns data's of the user",
     *      security={{ "bearer_token": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     *  )
     * Returns data's of the user
     */
    public function update(Request $request, User $user) : JsonResponse
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

        return $this->sendResponse($user, "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="destroy",
     *      tags={"User"},
     *      summary="Delete One User",
     *      description="Returns true or false",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the User you want to delete",
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
     *     )
     *
     * Returns true or false
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->sendResponse($user, "User deleted successfully");
    }
}
