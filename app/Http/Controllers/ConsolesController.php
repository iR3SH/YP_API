<?php

namespace App\Http\Controllers;

use App\Models\Consoles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConsolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $console = Consoles::all();
        return [
            "status" => 1,
            "data" => $console
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
        $console = Consoles::create($request->all());
        return [
            'status' => 1,
            "data" => $console,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Consoles $console
     * @return array
     */
    public function show(Consoles $console): array
    {
        return [
            "status" => 1,
            "data" => $console
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Consoles $console
     * @return Response
     */
    public function edit(Consoles $console)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Consoles $console
     * @return array
     */
    public function update(Request $request, Consoles $console): array
    {
        $request->validate([
            'name' => 'required',
        ]);
        $console->name = $request->get('name');
        $console->save();
        return [
            'status' => 1,
            "data" => $console,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Consoles $console
     * @return array
     */
    public function destroy(Consoles $console): array
    {
        $console->delete();
        return [
            "status" => 1,
            "data" => $console,
            "msg" => "Console deleted successfully"
        ];
    }
}
