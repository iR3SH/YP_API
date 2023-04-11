<?php

namespace App\Http\Controllers;

use App\Models\Sports;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $sport = Sports::all();
        return [
            "status" => 1,
            "data" => $sport
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
        $sport = Sports::create($request->all());
        return [
            'status' => 1,
            "data" => $sport,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Sports $sport
     * @return array
     */
    public function show(Sports $sport): array
    {
        return [
            "status" => 1,
            "data" => $sport
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sports $sport
     * @return Response
     */
    public function edit(Sports $sport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sports $sport
     * @return array
     */
    public function update(Request $request, Sports $sport): array
    {
        $request->validate([
            'name' => 'required',
        ]);
        $sport->name = $request->get('name');
        $sport->save();
        return [
            'status' => 1,
            "data" => $sport,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sports $sport
     * @return array
     */
    public function destroy(Sports $sport): array
    {
        $sport->delete();
        return [
            "status" => 1,
            "data" => $sport,
            "msg" => "Sport deleted successfully"
        ];
    }
}
