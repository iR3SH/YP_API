<?php

namespace App\Http\Controllers;

use App\Models\SuperLikes;
use Illuminate\Http\Request;

class SuperLikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $superlikes = SuperLikes::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $superlikes,
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
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $superlikes = SuperLikes::create($request->all());

        return [
            "status" => 1,
            "data" => $superlikes,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param SuperLikes $superlikes
     * @return array
     */
    public function show(SuperLikes $superlikes): array
    {
        return [
            'status' => 1,
            'data' => $superlikes
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SuperLikes $superlikes
     * @return Response
     */
    public function edit(SuperLikes $superlikes)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Likes $superlikes
     * @return array
     */
    public function update(Request $request, SuperLikes $superlikes): array
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $superlikes->update($request->all());
        return [
            "status" => 1,
            "data" => $superlikes,
            "msg" => "SuperLike updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SuperLikes $superlikes
     * @return array
     */
    public function destroy(SuperLikes $superlikes): array
    {
        $superlikes->delete();
        return [
            "status" => 1,
            "msg" => "SuperLike deleted successfully",
            "data" => $superlikes,
        ];
    }
}
