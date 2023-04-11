<?php

namespace App\Http\Controllers;

use App\Models\Plateformes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlateformesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $plateformes = Plateformes::all();
        return [
            "status" => 1,
            "data" => $plateformes
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
            'name' => 'required',
        ]);
        $plateformes = Plateformes::create($request->all());
        return [
            'status' => 1,
            "data" => $plateformes,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Plateformes $plateformes
     * @return array
     */
    public function show(Plateformes $plateformes): array
    {
        return [
            "status" => 1,
            "data" => $plateformes
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Plateformes $plateformes
     * @return Response
     */
    public function edit(Plateformes $plateformes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Plateformes $plateformes
     * @return array
     */
    public function update(Request $request, Plateformes $plateformes): array
    {
        $request->validate([
            'name' => 'required',
        ]);
        $plateformes->name = $request->get('name');
        $plateformes->save();
        return [
            'status' => 1,
            "data" => $plateformes,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plateformes $plateformes
     * @return array
     */
    public function destroy(Plateformes $plateformes): array
    {
        $plateformes->delete();
        return [
            "status" => 1,
            "data" => $plateformes,
            "msg" => "Plateforme deleted successfully"
        ];
    }
}
