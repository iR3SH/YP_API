<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $sctivitie = Activities::all();
        return [
            "status" => 1,
            "data" => $sctivitie
        ];
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
            'name' => 'nullable',
            'type' => 'nullable',
            'idJeux' => 'nullable',
            'idMovieType' => 'nullable',
            'idSortie' => 'nullable',
            'idSport' => 'nullable',
        ]);
        $sctivitie = Activities::create($request->all());
        return [
            'status' => 1,
            "data" => $sctivitie,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Activities $sctivitie
     * @return array
     */
    public function show(Activities $sctivitie): array
    {
        return [
            "status" => 1,
            "data" => $sctivitie
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Activities $sctivitie
     * @return Response
     */
    public function edit(Activities $sctivitie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Activities $sctivitie
     * @return array
     */
    public function update(Request $request, Activities $sctivitie): array
    {
        $request->validate([
            'name' => 'nullable',
            'type' => 'nullable',
            'idJeux' => 'nullable',
            'idMovieType' => 'nullable',
            'idSortie' => 'nullable',
            'idSport' => 'nullable',
        ]);
        if($request->get('name') != null) {
            $sctivitie->name = $request->get('name');
        }
        if($request->get('type') != null) {
            $sctivitie->type = $request->get('type');
        }
        if($request->get('idJeux') != null) {
            $sctivitie->idJeux = $request->get('idJeux');
        }
        if($request->get('idMovieType') != null) {
            $sctivitie->idMovieType = $request->get('idMovieType');
        }
        if($request->get('idSortie') != null) {
            $sctivitie->idSortie = $request->get('idSortie');
        }
        if($request->get('idSport') != null) {
            $sctivitie->idSport = $request->get('idSport');
        }
        $sctivitie->save();
        return [
            'status' => 1,
            "data" => $sctivitie,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Activities $sctivitie
     * @return array
     */
    public function destroy(Activities $sctivitie): array
    {
        $sctivitie->delete();
        return [
            "status" => 1,
            "data" => $sctivitie,
            "msg" => "Activity deleted successfully"
        ];
    }
}
