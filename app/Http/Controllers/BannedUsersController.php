<?php

namespace App\Http\Controllers;

use App\Models\BannedUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/bannedUsers",
     *      operationId="indexBannedUsers",
     *      tags={"BannedUsers"},
     *      summary="Get list of BannedUsers",
     *      description="Returns list of BannedUsers",
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
     * Returns list of BannedUsers
     */
    public function index(): JsonResponse
    {
        $bannedUsers = BannedUsers::all();

        return $this->sendResponse($bannedUsers, "List of BannedUsers");
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
     *      path="/api/bannedUsers",
     *      operationId="storeBannedUsers",
     *      tags={"BannedUsers"},
     *      summary="Create a BannedUsers",
     *      description="Returns a BannedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="reason",
     *         in="query",
     *         description="reason of the Ban",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="isLifeTime",
     *         in="query",
     *         description="it is a life time ban ?",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="Id of the BannedUser",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idAdmin",
     *         in="query",
     *         description="Id of the Admin",
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
     * Returns a BannedUsers
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "reason" => 'required',
            "isLifeTime" => 'required',
            "idUser" => 'required',
            "idAdmin" => 'required',
        ]);
        if($this->isAdminUser($request->idAdmin)) {
            $data = $request->all();
            $data->array_push(['timestamp' => time()]);
            $bannedUser = BannedUsers::create($data);

            return $this->sendResponse($bannedUser, "The User has been Banned");
        }
        return $this->sendError("Route not found");
    }

    /**
     * Display the specified resource.
     *
     * @param BannedUsers $bannedUser
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/bannedUsers/{idUser}",
     *      operationId="showBannedUsers",
     *      tags={"BannedUsers"},
     *      summary="Get a BannedUsers",
     *      description="Returns a BannedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
     *         description="Id of the BannedUser",
     *         required=false,
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
     * Returns a BannedUsers
     */
    public function show(BannedUsers $bannedUser): JsonResponse
    {
        return $this->sendResponse($bannedUser, "Found !");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BannedUsers $bannedUsers
     * @return Response
     */
    public function edit(BannedUsers $bannedUsers)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param BannedUsers $bannedUsers
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/bannedUsers/{id}",
     *      operationId="updateBannedUsers",
     *      tags={"BannedUsers"},
     *      summary="Update a BannedUsers",
     *      description="Returns a BannedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Ban",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="reason",
     *         in="query",
     *         description="reason of the Ban",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="isLifeTime",
     *         in="query",
     *         description="it is a life time ban ?",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="Id of the BannedUser",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idAdmin",
     *         in="query",
     *         description="Id of the Admin",
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
     * Returns a BannedUsers
     */
    public function update(Request $request, BannedUsers $bannedUser): JsonResponse
    {
        $request->validate([
            "timestamp" => 'required',
            "reason" => 'required',
            "idUser" => 'required',
            "idAdmin" => 'required',
            "isLifeTime" => 'required',
        ]);

        $bannedUser->update($request->all());
        return $this->sendResponse($bannedUser, "Banned User updated !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BannedUsers $bannedUsers
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/bannedUsers/{id}",
     *      operationId="destroyBannedUsers",
     *      tags={"BannedUsers"},
     *      summary="Delete a BannedUsers",
     *      description="Returns a BannedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the BannedUser",
     *         required=false,
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
     * Returns a BannedUsers
     */
    public function destroy(BannedUsers $bannedUsers): JsonResponse
    {
        $bannedUsers->delete();
        return $this->sendResponse($bannedUsers, "was deleted successfully");
    }
}
