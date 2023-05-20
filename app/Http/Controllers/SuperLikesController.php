<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Models\Matchs;
use App\Models\Messages;
use App\Models\SuperLikes;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuperLikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/superLikes",
     *      operationId="indexSuperLikes",
     *      tags={"SuperLikes"},
     *      summary="Get list of SuperLikes",
     *      description="Returns list of SuperLikes",
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
     * Returns list of SuperLikes
     */
    public function index(): JsonResponse
    {
        $superlikes = SuperLikes::all();

        return $this->sendResponse($superlikes, "SuperLikes found");
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
     *      path="/api/superLikes",
     *      operationId="storeSuperLikes",
     *      tags={"SuperLikes"},
     *      summary="Get list of SuperLikes",
     *      description="Returns list of SuperLikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserWhoLiked",
     *         in="query",
     *         description="id of the User who SuperLiked",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUserWhoBeLiked",
     *         in="query",
     *         description="id of the User who be SuperLiked",
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
     * Returns list of SuperLikes
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);
        $verif = SuperLikes::where('idUserWhoLiked', $request->get('idUserWhoLiked'))->where('idUserWhoBeLiked', $request->get('idUserWhoBeLiked'))->get();
        if(count($verif) > 0){
            return $this->sendError('Already SuperLiked');
        }
        $verif2= User::where('id', $request->get('idUserWhoLiked'))->get()[0];
        if($verif2->superLikeCount == 0){
            return $this->sendError("User doesn't have enough super likes");
        }
        $superlikes = SuperLikes::create($request->all());
        $verif2->superLikeCount -= 1;
        $verif2->save();
        $match = Matchs::create([
            'idUser' => $request->get('idUserWhoLiked'),
            'idUser2' => $request->get('idUserWhoBeLiked')
        ]);
        $conversation = Conversations::create([
            'idFirstUser' => $request->get('idUserWhoLiked'),
            'idSecondUser' => $request->get('idUserWhoBeLiked')
        ]);
        return $this->sendResponse([$superlikes, $match, $conversation], "SuperLiked Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param SuperLikes $superlike
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/superLikes/{id}",
     *      operationId="showSuperLikes",
     *      tags={"SuperLikes"},
     *      summary="Get a SuperLikes",
     *      description="Returns a SuperLikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the SuperLike",
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
     * Returns a SuperLikes
     */
    public function show(SuperLikes $superlike): JsonResponse
    {
        return $this->sendResponse($superlike, "Founded");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SuperLikes $superlikes
     * @return Response
     */
    public function edit(SuperLikes $superlikes)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param SuperLikes $superlike
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/superLikes/{id}",
     *      operationId="updateSuperLikes",
     *      tags={"SuperLikes"},
     *      summary="Update a SuperLikes",
     *      description="Returns a SuperLikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the SuperLike",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idFirstuser",
     *         in="query",
     *         description="id of the first user",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idSecondUser",
     *         in="query",
     *         description="id of the second user",
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
     * Returns a SuperLikes
     */
    public function update(Request $request, SuperLikes $superlike): JsonResponse
    {
        $request->validate([
            "idFirstUser" => 'required',
            "idSecondUser" => 'required',
        ]);

        $superlike->update($request->all());
        return $this->sendResponse($superlike, "SuperLike Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SuperLikes $superlike
     * @return JsonResponse
     */
    /**
     * @OA\delete(
     *      path="/api/superLikes/{id}",
     *      operationId="deleteSuperLikes",
     *      tags={"SuperLikes"},
     *      summary="Delete a SuperLikes",
     *      description="Returns a SuperLikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the SuperLike",
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
     * Returns a SuperLikes
     */
    public function destroy(SuperLikes $superlike): JsonResponse
    {
        $this->destroyMatchRelation($superlike->idFirstUser, $superlike->idSecondUser);
        $superlike->delete();

        return $this->sendResponse($superlike, "Deleted successfully");
    }
}
