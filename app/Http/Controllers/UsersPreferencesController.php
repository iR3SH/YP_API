<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersPreferences;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersPreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/usersPreferences",
     *      operationId="indexUserPref",
     *      tags={"Users Preferences"},
     *      summary="Get list of Users Preferences",
     *      description="Returns list of Users Preferences",
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
     * Returns list of Users Preferences
     */
    public function index() : JsonResponse
    {
        $preferencies = UsersPreferences::all();

        return $this->sendResponse($preferencies, "Listing successful");
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
     * @param  Request  $request
     * @return JsonResponse
     */

    /**
     * @OA\Post(
     *      path="/api/usersPreferences",
     *      operationId="storeuserspreferences",
     *      tags={"Users Preferences"},
     *      summary="Insert a new Users Preferences",
     *      description="Returns a new Users Preferences",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="musicsStyles",
     *         in="query",
     *         description="musicsStyles for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="redFlags",
     *         in="query",
     *         description="redFlags for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="languages",
     *         in="query",
     *         description="languages for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="genderPref",
     *         in="query",
     *         description="genderPref for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="distancePref",
     *         in="query",
     *         description="distancePref for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="idUser of the new User",
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
            "musicsStyles" => 'string',
            "redFlags" => 'string',
            "languages" => 'string',
            "genderPref" => 'string',
            "distancePref" => 'integer',
            "idUser" => 'required',
        ]);

        if(User::where('id', $request->get('idUser')) != null)
        {
            $user = UsersPreferences::create($request->all());
            return $this->sendResponse($user, "UserPreferences created successfully");
        }
        else
        {
            return $this->sendError("UserPreferences not found");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  UsersPreferences  $usersPreference
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/usersPreferences/{idUser}",
     *      operationId="showUserPref",
     *      tags={"Users Preferences"},
     *      summary="Get infos of Users Preferences",
     *      description="Returns infos of Users Preferences",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="idUser of User",
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
     * Returns infos of Users Preferences
     */
    public function show(Request $request) : JsonResponse
    {
        $request->validate([
            'idUser' => 'required',
        ]);
        $usersPreference = UsersPreferences::where('idUser', $request->get('idUser'))->get();
        if($usersPreference != null){
            if($usersPreference[0] != null){
                return $this->sendResponse($usersPreference[0], "User Pref founded !");
            }
        }
        return $this->sendError("User Pref not found !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UsersPreferences  $usersPreference
     * @return Response
     */
    public function edit(UsersPreferences $usersPreference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UsersPreferences $usersPreference
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/usersPreferences",
     *      operationId="updateuserspreferences",
     *      tags={"Users Preferences"},
     *      summary="Update Users Preferences",
     *      description="Returns a Users Preferences",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="musicsStyles",
     *         in="query",
     *         description="musicsStyles for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="redFlags",
     *         in="query",
     *         description="redFlags for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="languages",
     *         in="query",
     *         description="languages for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="genderPref",
     *         in="query",
     *         description="genderPref for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="distancePref",
     *         in="query",
     *         description="distancePref for the new User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="idUser of the new User",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *     )
     * )
     * Returns a user Preferences
     */
    public function update(Request $request, UsersPreferences $usersPreference) : JsonResponse
    {
        $request->validate([
            "musicsStyles" => 'string',
            "redFlags" => 'string',
            "languages" => 'string',
            "genderPref" => 'string',
            "distancePref" => 'integer',
            "idUser" => 'required',

        ]);

        if(UsersPreferences::where('id', $request->get('idUser')) != null)
        {
            $usersPreference->update($request->all());

            return $this->sendResponse($usersPreference, "UserPreferences updated successfully");
        }
        else
        {
            return $this->sendError("UserPreferences not found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Delete (
     *      path="/api/usersPreferences/{idUser}",
     *      operationId="deleteUserPref",
     *      tags={"Users Preferences"},
     *      summary="Delete on Users Preferences",
     *      description="Returns infos of Users Preferences",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
     *         description="idUser of User",
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
     * Returns infos of Users Preferences
     */
    public function destroy(UsersPreferences $usersPreference) : JsonResponse
    {
        $usersPreference->delete();
        return $this->sendResponse($usersPreference, "Deleted successfully");
    }
}
