<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPrefsActivities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psy\Util\Json;

class UsersPrefsActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    /**
     * @OA\Get(
     *      path="/api/usersPrefsActivities",
     *      operationId="indexUsersPrefsActivities",
     *      tags={"UsersPrefsActivities"},
     *      summary="Get list of UsersPrefsActivities",
     *      description="Returns list of UsersPrefsActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who ask the request",
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
     * Returns list of UsersPrefsActivities
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        $usersPrefsActivitie = UsersPrefsActivities::where('idUser', $request->get('idUser'))->get();
        if(count($usersPrefsActivitie) > 0) {
            return $this->sendResponse($usersPrefsActivitie, "List users preferences Activities");
        }
        return $this->sendError("No result Found");
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
     *      path="/api/usersPrefsActivities",
     *      operationId="storeUsersPrefsActivities",
     *      tags={"UsersPrefsActivities"},
     *      summary="Create a UsersPrefsActivities",
     *      description="Returns a UsersPrefsActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserPref",
     *         in="query",
     *         description="id of the User who ask the request",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idActivity",
     *         in="query",
     *         description="id of Activity",
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
     * Returns a UsersPrefsActivities
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'idUserPref' => 'required',
            'idActivity' => 'required'
        ]);
        $usersPrefsActivitie = UsersPrefsActivities::create($request->all());
        return $this->sendResponse($usersPrefsActivitie, "User Activity Preference Created");
    }

    /**
     * Display the specified resource.
     *
     * @param UsersPrefsActivities $usersPrefsActivitie
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/usersPrefsActivities/{id}",
     *      operationId="showUsersPrefsActivities",
     *      tags={"UsersPrefsActivities"},
     *      summary="Get a UsersPrefsActivities",
     *      description="Returns a UsersPrefsActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the UserPrefActivity",
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
     * Returns a UsersPrefsActivities
     */
    public function show(UsersPrefsActivities $usersPrefsActivitie): JsonResponse
    {
        return $this->sendResponse($usersPrefsActivitie, "User Activity Preference found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UsersPrefsActivities $usersPrefsActivitie
     * @return Response
     */
    public function edit(UsersPrefsActivities $usersPrefsActivitie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UsersPrefsActivities $usersPrefsActivitie
     * @return JsonResponse
     */
    public function update(Request $request, UsersPrefsActivities $usersPrefsActivitie): JsonResponse
    {
        return $this->sendError("Not in use");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UsersPrefsActivities $usersPrefsActivitie
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/usersPrefsActivities/{id}",
     *      operationId="destroyUsersPrefsActivities",
     *      tags={"UsersPrefsActivities"},
     *      summary="Delete a UsersPrefsActivities",
     *      description="Returns a UsersPrefsActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the UserPrefActivity",
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
     * Returns a UsersPrefsActivities
     */
    public function destroy(UsersPrefsActivities $usersPrefsActivitie): JsonResponse
    {
        $usersPrefsActivitie->delete();
        return $this->sendResponse($usersPrefsActivitie, "User Activity Preference successfully deleted");
    }
}
