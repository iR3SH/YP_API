<?php

namespace App\Http\Controllers;

use App\Models\MoviesType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $movieType = MoviesType::all();
        return [
            "status" => 1,
            "data" => $movieType
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
        $movieType = MoviesType::create($request->all());
        return [
            'status' => 1,
            "data" => $movieType,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param MoviesType $movieType
     * @return array
     */
    public function show(MoviesType $movieType): array
    {
        return [
            "status" => 1,
            "data" => $movieType
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MoviesType $movieType
     * @return Response
     */
    public function edit(MoviesType $movieType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MoviesType $movieType
     * @return array
     */
    public function update(Request $request, MoviesType $movieType): array
    {
        $request->validate([
            'name' => 'required',
        ]);
        $movieType->title = $request->get('name');
        $movieType->save();
        return [
            'status' => 1,
            "data" => $movieType,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MoviesType $movieType
     * @return array
     */
    public function destroy(MoviesType $movieType): array
    {
        $movieType->delete();
        return [
            "status" => 1,
            "data" => $movieType,
            "msg" => "Sortie deleted successfully"
        ];
    }
}
