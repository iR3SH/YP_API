<?php

namespace App\Http\Controllers;

use App\Models\Dislikes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DislikesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/dislikes",
     *      operationId="indexDislikes",
     *      tags={"Dislikes"},
     *      summary="Get list of Dislikes",
     *      description="Returns list of Dislikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idWhoDisliked",
     *         in="query",
     *         description="id of the Dislike",
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
        $Dislikes = null;
        if($request->get('idWhoDisliked') != null) {
            $Dislikes = Dislikes::where('idWhoDisliked', $request->get('idWhoDisliked'))->get();
        }
        else{
            $Dislikes = Dislikes::lastest()->paginate(10);
        }

        if($Dislikes != null) {
            return $this->sendResponse($Dislikes, "Dislikes found");
        }
        else
        {
            return $this->sendError('User has none dislikes');
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
     *      path="/api/dislikes",
     *      operationId="storeDislikes",
     *      tags={"Dislikes"},
     *      summary="Create Dislikes",
     *      description="Returns created Dislikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idWhoDisliked",
     *         in="query",
     *         description="id from the User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idWhoBeDisliked",
     *         in="query",
     *         description="id of the Disliked user",
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
     * Returns created Dislikes
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idWhoDisliked" => 'required',
            "idWhoBeDisliked" => 'required',
        ]);
        $verif = Dislikes::where('idWhoDisliked', $request->get('idWhoDisliked'))->where('idWhoBeDisliked', $request->get('idWhoBeDisliked'))->get();
        if(count($verif) > 0){
            return $this->sendError('User already disliked');
        }
        $Dislikes = Dislikes::create($request->all());

        return $this->sendResponse($Dislikes, "Dislikes created successfully");
    }

    /**
     * @OA\Get(
     *      path="/api/dislikes/{id}",
     *      operationId="showDislikes",
     *      tags={"Dislikes"},
     *      summary="Get Dislikes",
     *      description="Returns Dislikes",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Dislike",
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
     * Returns Dislikes
     */
    public function show(Dislikes $dislike): JsonResponse
    {
        return $this->sendResponse($dislike, "Dislike Founded");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dislikes $Dislikes
     * @return Response
     */
    public function edit(Dislikes $Dislikes)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Dislikes $Dislikes
     * @return array
     */
    public function update(Request $request, Dislikes $Dislikes): array
    {
        $request->validate([
            "idWhoDisliked" => 'required',
            "idWhoBeDisliked" => 'required',
        ]);

        $Dislikes->update($request->all());
        return [
            "status" => 1,
            "data" => $Dislikes,
            "msg" => "Dislikes updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dislikes $Dislikes
     * @return array
     */
    /**
     * @OA\Delete(
     *      path="/api/dislikes/{id}",
     *      operationId="destroyDislikes",
     *      tags={"Dislikes"},
     *      summary="Delete a Dislikes",
     *      description="Returns the deleted Dislike",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Dislike",
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
     * Returns the deleted Dislike
     */
    public function destroy(Dislikes $dislike): JsonResponse
    {
        $dislike->delete();
        return $this->sendResponse($dislike, "Deleted successfully");
    }
}
