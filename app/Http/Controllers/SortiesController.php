<?php

namespace App\Http\Controllers;

use App\Models\Sorties;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SortiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $sortie = Sorties::all();
        return [
            "status" => 1,
            "data" => $sortie
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
            'title' => 'required',
        ]);
        $sortie = Sorties::create($request->all());
        return [
            'status' => 1,
            "data" => $sortie,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Sorties $sortie
     * @return array
     */
    public function show(Sorties $sortie): array
    {
        return [
            "status" => 1,
            "data" => $sortie
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sorties $sortie
     * @return Response
     */
    public function edit(Sorties $sortie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sorties $sortie
     * @return array
     */
    public function update(Request $request, Sorties $sortie): array
    {
        $request->validate([
            'title' => 'required',
        ]);
        $sortie->title = $request->get('title');
        $sortie->save();
        return [
            'status' => 1,
            "data" => $sortie,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sorties $sortie
     * @return array
     */
    public function destroy(Sorties $sortie): array
    {
        $sortie->delete();
        return [
            "status" => 1,
            "data" => $sortie,
            "msg" => "Sortie deleted successfully"
        ];
    }
}
