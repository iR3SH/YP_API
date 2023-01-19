<?php

namespace App\Http\Controllers;

use App\Models\Dislikes;
use Illuminate\Http\Request;

class DislikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $Dislikes = Dislikes::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $Dislikes,
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
     * @param  Request  $request
     * @return array
     */
    public function store(Request $request): array
    {
        $request->validate([
            "idUserWhoDisliked" => 'required',
            "idUserWhoBeDisliked" => 'required',
        ]);

        $Dislikes = Dislikes::create($request->all());

        return [
            "status" => 1,
            "data" => $Dislikes,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Dislikes $Dislikes
     * @return array
     */
    public function show(Dislikes $Dislikes): array
    {
        return [
            'status' => 1,
            'data' => $Dislikes
        ];
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
            "idUserWhoDisliked" => 'required',
            "idUserWhoBeDisliked" => 'required',
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
    public function destroy(Dislikes $Dislikes): array
    {
        $Dislikes->delete();
        return [
            "status" => 1,
            "msg" => "Dislikes deleted successfully",
            "data" => $Dislikes,
        ];
    }
}
