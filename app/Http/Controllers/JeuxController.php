<?php

namespace App\Http\Controllers;

use App\Models\Jeux;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JeuxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/jeux",
     *      operationId="indexGames",
     *      tags={"Jeux"},
     *      summary="Get list of Games",
     *      description="Returns list of Games",
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
     * Returns list of Games
     */
    public function index(): JsonResponse
    {
        $jeu = Jeux::all();
        return $this->sendResponse($jeu, "Done successfully");
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
    public function store(Request $request): array
    {
        $request->validate([
            'name' => 'required',
            'idConsole' => 'required',
            'idPlateforme' => 'required',
        ]);
        $jeu = Jeux::create($request->all());
        return [
            'status' => 1,
            "data" => $jeu,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Jeux $jeu
     * @return array
     */
    public function show(Jeux $jeu): array
    {
        return [
            "status" => 1,
            "data" => $jeu
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Jeux $jeu
     * @return Response
     */
    public function edit(Jeux $jeu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Jeux $jeu
     * @return array
     */
    public function update(Request $request, Jeux $jeu): array
    {
        $request->validate([
            'name' => 'required',
            'idConsole' => 'required',
            'idPlateforme' => 'required',
        ]);
        $jeu->name = $request->get('name');
        $jeu->idConsole = $request->get('idConsole');
        $jeu->idPlateforme = $request->get('idPlateforme');
        $jeu->save();
        return [
            'status' => 1,
            "data" => $jeu,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Jeux $jeu
     * @return array
     */
    public function destroy(Jeux $jeu): array
    {
        $jeu->delete();
        return [
            "status" => 1,
            "data" => $jeu,
            "msg" => "Game deleted successfully"
        ];
    }
}
