<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Models\Matchs;
use App\Models\Messages;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/matchs",
     *      operationId="indexMatchs",
     *      tags={"Matchs"},
     *      summary="Get list of Matchs",
     *      description="Returns list of Matchs",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User 1",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser2",
     *         in="query",
     *         description="id of the User 2",
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
     * Returns list of Matchs
     */
    public function index(Request $request): JsonResponse
    {
        $matchs = Matchs::all();
        if($request->get('idUser') != null || $request->get('idUser2') != null)
        {
            $request->validate([
                'idUser' => 'required',
                'idUser2' => 'required'
            ]);
            $matchs = Matchs::where('idUser', $request->get('idUser'))->where('idUser2', $request->get('idUser2'))->get();
            if(count($matchs) > 0){
                return $this->sendResponse($matchs, 'Match send successfully');
            }
            else{
                return $this->sendError("Match doesn't exist");
            }
        }
        return $this->sendResponse($matchs, "Done Successfully");
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
     *      path="/api/Matchs",
     *      operationId="storeMatchs",
     *      tags={"Matchs"},
     *      summary="Register a new Matchs",
     *      description="Returns the new Matchs",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User 1",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser2",
     *         in="query",
     *         description="id of the User 2",
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
     * Returns the new Matchs
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idUser" => 'required',
            "idUser2" => 'required',
        ]);

        $matchs = Matchs::create($request->all());

        return $this->sendResponse($matchs, "Added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param Matchs $like
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/Matchs/{id}",
     *      operationId="showMatchs",
     *      tags={"Matchs"},
     *      summary="Get a Matchs relation",
     *      description="Returns a Matchs relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User 1",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser2",
     *         in="query",
     *         description="id of the User 2",
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
     * Returns the new Matchs
     */
    public function show(Request $request, Matchs $match): JsonResponse
    {
        $request->validate([
            "idUser" => 'required',
            "idUser2" => 'required',
        ]);

        if($match != null)
        {
            return $this->sendResponse($match, "Showed Successfully");
        }
        return $this->sendError("Error to search the specific like relation");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Matchs $match
     * @return Response
     */
    public function edit(Matchs $match)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Matchs $match
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/Matchs",
     *      operationId="updateMatchs",
     *      tags={"Matchs"},
     *      summary="Update a Like relation (Not in Use in the futur)",
     *      description="Returns a Like relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who Liked",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idUser2",
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
     * Returns the new Matchs
     */
    public function update(Request $request, Matchs $match): JsonResponse
    {
        $request->validate([
            "idUser" => 'required',
            "idUser2" => 'required',
        ]);
        $match->update($request->all());

        return $this->sendResponse($match, "Like updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Matchs $match
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/Matchs/{id}",
     *      operationId="deleteMatchs",
     *      tags={"Matchs"},
     *      summary="Delete a Matchs relation",
     *      description="Returns a Matchs relation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Matchs Relation",
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
     * Delete the match / messages & conversation
     */
    public function destroy(Matchs $match): JsonResponse
    {
        $this->destroyMatchRelation($match->idUser, $match->idUser2);
        $match->delete();

        return $this->sendResponse($match, "Match relation deleted successfully");
    }

}
