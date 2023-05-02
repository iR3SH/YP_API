<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersActivities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/usersActivities",
     *      operationId="indexUsersActivities",
     *      tags={"UsersActivities"},
     *      summary="Get list of UsersActivities",
     *      description="Returns list of UsersActivities",
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
     * Returns list of UsersActivities
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        $usersActivitie = UsersActivities::where('idUser', $request->get('idUser'))->get();
        if(count($usersActivitie) > 0) {
            return $this->sendResponse($usersActivitie, "List users Activities");
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
     *      path="/api/usersActivities",
     *      operationId="storeUsersActivities",
     *      tags={"UsersActivities"},
     *      summary="Create a UsersActivities",
     *      description="Returns list of UsersActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idActivity",
     *         in="query",
     *         description="id of the Activity",
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
     * Returns a UsersActivities
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required',
            'idActivity' => 'required'
        ]);
        $usersActivitie = UsersActivities::create($request->all());
        return $this->sendResponse($usersActivitie, "Activity registred for user");
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/usersActivities/{id}",
     *      operationId="showUsersActivities",
     *      tags={"UsersActivities"},
     *      summary="Get the UsersActivities",
     *      description="Returns the UsersActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
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
     * Returns the UsersActivities
     */
    public function show(UsersActivities $usersActivitie): JsonResponse
    {
        return $this->sendResponse($usersActivitie, "Found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UsersActivities $user
     * @return Response
     */
    public function edit(UsersActivities $usersActivitie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UsersActivities $usersActivitie
     * @return JsonResponse
     */
    public function update(Request $request, UsersActivities $usersActivitie): JsonResponse
    {
        return $this->sendError("Not in use");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UsersActivities $usersActivitie
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/usersActivities/{id}",
     *      operationId="destroyUsersActivities",
     *      tags={"UsersActivities"},
     *      summary="Delete a UsersActivities",
     *      description="Returns list of UsersActivities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the User",
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
     * Returns a UsersActivities
     */
    public function destroy(UsersActivities $usersActivitie): JsonResponse
    {
        $usersActivitie->delete();
        return $this->sendResponse($usersActivitie, "User Activity deleted successfully");
    }
}
