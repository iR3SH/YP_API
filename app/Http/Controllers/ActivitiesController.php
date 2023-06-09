<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\ActivitiesType;
use App\Models\Consoles;
use App\Models\Jeux;
use App\Models\MoviesType;
use App\Models\Plateformes;
use App\Models\Sorties;
use App\Models\Sports;
use App\Models\TagsModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/activities",
     *      operationId="indexActivities",
     *      tags={"Activities"},
     *      summary="Get list of Activities",
     *      description="Returns list of Activities",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type of the activity",
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
     * Returns list of Activities
     */
    public function index(Request $request): JsonResponse
    {
        $activityType = null;
        $activities = null;
        $returnsData = [];
        if($request->get('type') != null){
            $activityType = $request->get('type');
            $activities = Activities::where('type', $activityType)->get();
        }
        else {
            $activities = Activities::all();
        }
        foreach ($activities as $activity) {
            $activity_to_push = [];
            $tag = null;
            array_push($activity_to_push, ["idActivity" => $activity->id], ["idType" => $activity->type]);
            switch ($activity->type) {
                case 1:
                    $movieType = MoviesType::where('id', $activity->idMovieType)->get()[0];
                    array_push($activity_to_push, ["name" => $movieType->name]);
                    break;
                case 2:
                    $sport = Sports::where('id', $activity->idSport)->get()[0];
                    array_push($activity_to_push, ["name" => $sport->name]);
                    break;
                case 3:
                    $jeux = Jeux::where('id', $activity->idJeux)->get()[0];
                    $plateforme = Plateformes::where('id', $jeux->idPlateforme)->get()[0];
                    $console = Consoles::where('id', $jeux->idConsole)->get()[0];
                    array_push($activity_to_push, ["name" => $jeux->name]);
                    break;
                case 4 :
                    $jeux = Jeux::where('id', $activity->idJeux)->get()[0];
                    array_push($activity_to_push, ["name" => $jeux->name]);
                    break;
                case 5:
                case 6:
                    $sortie = Sorties::where('id', $activity->idSortie)->get()[0];
                    array_push($activity_to_push, ["name" => $sortie->name]);
                    break;
                default:
                    $this->sendError('No object from type ' . $activity->type . ' was found');
                    break;
            }
            $tag = new TagsModel([
                "id" => $activity_to_push[0]["idActivity"],
                "type" => $activity_to_push[1]['idType'],
                'name' => $activity_to_push[2]['name']
            ]);
            array_push($returnsData, $tag);
        }
        return $this->sendResponse($returnsData, "List found");
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
    /**
     * @OA\Post(
     *      path="/api/activities",
     *      operationId="storeActivities",
     *      tags={"Activities"},
     *      summary="Create an Activity",
     *      description="Returns an Activity",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idJeux",
     *         in="query",
     *         description="idJeux of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idMovieType",
     *         in="query",
     *         description="idMovieType of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idSortie",
     *         in="query",
     *         description="idSortie of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idSport",
     *         in="query",
     *         description="idSport of the activity",
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
     * Returns an Activity
     */
    public function store(Request $request): array
    {
        $request->validate([
            'type' => 'nullable',
            'idJeux' => 'nullable',
            'idMovieType' => 'nullable',
            'idSortie' => 'nullable',
            'idSport' => 'nullable',
        ]);
        $activity = Activities::create($request->all());
        return [
            'status' => 1,
            "data" => $activity,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Activities $activity
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/activities/{id}",
     *      operationId="showActivities",
     *      tags={"Activities"},
     *      summary="Get an Activity",
     *      description="Returns an Activity",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the activity",
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
     * Returns an Activity
     */
    public function show(Activities $activity): JsonResponse
    {
        $type = null;
        $game = null;
        $console = null;
        $plateforme = null;
        $movieType = null;
        $sortie = null;
        $sport = null;
        if($activity->type != null){
            $type = ActivitiesType::where('id', $activity->type)->get();
        }
        if($activity->idJeux != null){
            $game = Jeux::where('id', $activity->idJeux)->get();
            if(count($game) > 0){
                if($game->idConsole != null){
                    $console = Consoles::where('id', $game->idConsole)->get();
                }
                if($game->idPlateforme != null){
                    $plateforme = Consoles::where('id', $game->idPlateforme)->get();
                }
            }
        }
        if($activity->idMovieType != null){
            $movieType = MoviesType::where('id', $activity->idMovieType)->get();
        }
        if($activity->idSortie != null){
            $sortie = Sorties::where('id', $activity->idSortie)->get();
        }
        if($activity->idSport != null){
            $sport = Sports::where('id', $activity->idSport)->get();
        }

        $data = [
            $activity,
            $type,
            $game,
            $console,
            $plateforme,
            $movieType,
            $sortie,
            $sport
        ];

        return $this->sendResponse($data, "Found activity");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Activities $activity
     * @return Response
     */
    public function edit(Activities $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Activities $activity
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/activities/{id}",
     *      operationId="updateActivities",
     *      tags={"Activities"},
     *      summary="Update an Activity",
     *      description="Returns an Activity",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idJeux",
     *         in="query",
     *         description="idJeux of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idMovieType",
     *         in="query",
     *         description="idMovieType of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idSortie",
     *         in="query",
     *         description="idSortie of the activity",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idSport",
     *         in="query",
     *         description="idSport of the activity",
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
     * Returns an Activity
     */
    public function update(Request $request, Activities $activity): JsonResponse
    {
        $request->validate([
            'type' => 'nullable',
            'idJeux' => 'nullable',
            'idMovieType' => 'nullable',
            'idSortie' => 'nullable',
            'idSport' => 'nullable',
        ]);
        if($request->get('type') != null) {
            $activity->type = $request->get('type');
        }
        if($request->get('idJeux') != null) {
            $activity->idJeux = $request->get('idJeux');
        }
        if($request->get('idMovieType') != null) {
            $activity->idMovieType = $request->get('idMovieType');
        }
        if($request->get('idSortie') != null) {
            $activity->idSortie = $request->get('idSortie');
        }
        if($request->get('idSport') != null) {
            $activity->idSport = $request->get('idSport');
        }
        $activity->save();
        return $this->sendResponse($activity, "Activity updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Activities $activity
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/activities/{id}",
     *      operationId="destroyActivities",
     *      tags={"Activities"},
     *      summary="Delete an Activity",
     *      description="Returns a deleted Activity",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the activity",
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
     * Returns a deleted Activity
     */
    public function destroy(Activities $activity): JsonResponse
    {
        $activity->delete();
        return $this->sendResponse($activity, "Activity successfully deleted");
    }
}
