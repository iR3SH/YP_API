<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $likes = Likes::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $likes,
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

        $likes = Likes::create($request->all());

        return [
            "status" => 1,
            "data" => $likes,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Likes $likes
     * @return array
     */
    public function show(Likes $likes): array
    {
        return [
            'status' => 1,
            'data' => $likes
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Likes $likes
     * @return Response
     */
    public function edit(Likes $likes)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Likes $likes
     * @return array
     */
    public function update(Request $request, Likes $likes): array
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $likes->update($request->all());
        return [
            "status" => 1,
            "data" => $likes,
            "msg" => "Like updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Likes $likes
     * @return array
     */
    public function destroy(Likes $likes): array
    {
        $likes->delete();
        return [
            "status" => 1,
            "msg" => "Likes deleted successfully",
            "data" => $likes,
        ];
    }
}
