<?php

namespace App\Http\Controllers;

use App\Models\Photos;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $photos = Photos::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $photos,
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

        $photos = Photos::create($request->all());

        return [
            "status" => 1,
            "data" => $photos,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Photos $photos
     * @return array
     */
    public function show(Photos $photos): array
    {
        return [
            'status' => 1,
            'data' => $photos
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Photos $photos
     * @return Response
     */
    public function edit(Photos $photos)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Photos $photos
     * @return array
     */
    public function update(Request $request, Photos $photos): array
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $photos->update($request->all());
        return [
            "status" => 1,
            "data" => $photos,
            "msg" => "Photo updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Photos $photos
     * @return array
     */
    public function destroy(Photos $photos): array
    {
        $photos->delete();
        return [
            "status" => 1,
            "msg" => "Photo deleted successfully",
            "data" => $photos,
        ];
    }
}
