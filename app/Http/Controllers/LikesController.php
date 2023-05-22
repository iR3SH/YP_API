<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Matchs;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/likes",
     *      operationId="indexLikes",
     *      tags={"Likes"},
     *      summary="Get list of Likes",
     *      description="Returns list of Likes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserWhoLiked",
     *         in="query",
     *         description="id of the User who Liked",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idUserWhoBeLiked",
     *         in="query",
     *         description="id of the User who be Liked",
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
     * Returns list of Likes
     */
    public function index(Request $request): JsonResponse
    {
        if($request->get('idUserWhoLiked') != null && $request->get('idUserWhoBeLiked') != null){
            $like = Likes::where('idUserWhoLiked', $request->get('idUserWhoLiked'))->where('idUserWhoBeLiked', $request->get('idUserWhoBeLiked'))->get();
            return $this->sendResponse($like, "Likes found");
        }
        else if($request->get('idUserWhoLiked') != null && $request->get('idUserWhoBeLiked') == null){
            $like = Likes::where('idUserWhoLiked', $request->get('idUserWhoLiked'))->get();
            $like += Likes::where('idUserWhoBeLiked', $request->get('idUserWhoLiked'))->get();
            return $this->sendResponse($like, "Likes found");
        }
        else{
            $likes = Likes::all();
            return $this->sendResponse($likes, "Done Successfully");
        }
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
     *      path="/api/likes",
     *      operationId="storeLikes",
     *      tags={"Likes"},
     *      summary="Register a new Like",
     *      description="Returns the new Likes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserWhoLiked",
     *         in="query",
     *         description="id of the User who Liked",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUserWhoBeLiked",
     *         in="query",
     *         description="id of the User who be Liked",
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
     * Returns the new Likes
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);
        $verif = Likes::where('idUserWhoLiked', '=', $request->get('idUserWhoLiked'))->where('idUserWhoBeLiked', '=', $request->get('idUserWhoBeLiked'))->get();
        if(count($verif) == 0) {
            $likes = Likes::create($request->all());
            $likesOther = Likes::where('idUserWhoLiked', $request->get('idUserWhoBeLiked'))->where('idUserWhoBeLiked', $request->get('idUserWhoLiked'))->get();
            if (count($likesOther) > 0) {
                $newMatch = Matchs::create(['idUser' => $likes->idUserWhoLiked, 'idUser2' => $likes->idUserWhoBeLiked]);
                return $this->sendResponse([$likes, $newMatch], "Added successfully");
            }

            return $this->sendResponse($likes, "Added successfully");
        }
        return $this->sendResponse($verif,"Like Already exist");
    }

    /**
     * Display the specified resource.
     *
     * @param Likes $like
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/likes/{idUserWhoLiked}",
     *      operationId="showLikes",
     *      tags={"Likes"},
     *      summary="Get a Like relation",
     *      description="Returns a Like relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserWhoLiked",
     *         in="path",
     *         description="id of the User who Liked",
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
     * Returns the new Likes
     */
    public function show(Likes $like): JsonResponse
    {

        return $this->sendResponse($like, "Showed Successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Likes $like
     * @return Response
     */
    public function edit(Likes $like)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Likes $like
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/likes",
     *      operationId="updateLikes",
     *      tags={"Likes"},
     *      summary="Update a Like relation (Not in Use in the futur)",
     *      description="Returns a Like relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUserWhoLiked",
     *         in="query",
     *         description="id of the User who Liked",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUserWhoBeLiked",
     *         in="query",
     *         description="id of the User who be Liked",
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
     * Returns the new Likes
     */
    public function update(Request $request, Likes $like): JsonResponse
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);
        $like->update($request->all());

        return $this->sendResponse($like, "Like updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Likes $like
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/likes/{id}",
     *      operationId="deleteLikes",
     *      tags={"Likes"},
     *      summary="Delete a Like relation",
     *      description="Returns a Like relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Like Relation",
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
     * Returns the new Likes
     */
    public function destroy(Likes $like): JsonResponse
    {
        $otherLike = Likes::where('idUserWhoLiked', $like->idUserWhoBeLiked)->where('idUserWhoBeLiked', $like->idUserWhoLiked)->get();
        if(count($otherLike) > 0) {
            $this->destroyMatchRelation($like->idUserWhoLiked, $like->idUserWhoBeLiked);
            $like->delete();
            return $this->sendResponse($like, "Like relation and match deleted successfully");
        }
        else {
            $like->delete();
            return $this->sendResponse($like, "Like relation deleted successfully");
        }
    }
}
