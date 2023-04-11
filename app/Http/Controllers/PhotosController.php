<?php

namespace App\Http\Controllers;

use App\Models\Photos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $photos = Photos::all();

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
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            "idUser" => 'required',
        ]);
        $imageUser = Photos::where('idUser', $request->get('idUser'))->orderBy('position')->get();
        $oldImage = null;
        if($request->get('id') != null){
            $oldImage = Photos::where('id', $request->get('id'))->get()[0];
        }

        $image = $request->file('image');
        $tchek = false;
        $newImageName = "";

        // Vérification qu'il n'y a pas d'image portant le même nom
        while ($tchek == false) {
            $testName = Hash::make(basename($image->path()));
            $newImageName = $testName .'.'. $image->extension();
            $tchekDoubleName = Photos::where('fileName', $newImageName)->get();
            if (count($tchekDoubleName) < 1 || $tchekDoubleName == null) {
                $tchek = true;
            }
        }

        $position = 1;

        $image->storeAs('users', $newImageName, 'public');

        // Vérification si l'user à déjà upload d'autres images pour la position
        if ($imageUser != null) {
            if (count($imageUser) > 0) {
                $position = $imageUser->last()->getAttribute('position') + 1;
            }
        }
        // Vérification que la position soit correcte
        if ($position > 9) {
            return $this->sendError('Position', ['error'=>"Picture pos cant' be > 9"], 401);
        }
        if($oldImage == null) {
            $data = [
                'fileName' => $newImageName,
                'position' => $position,
                'length' => "2",
                'hash' => " ",
                'idUser' => $request->get('idUser'),
            ];
            $photos = Photos::create($data);
            return $this->sendResponse("Success", 'Pictures created successfully.');
        }
        else {
            unlink(public_path().'\\storage\\users\\'.$oldImage->fileName);
            $oldImage->fileName = $newImageName;

            $oldImage->save();
            return $this->sendResponse("Success", 'Pictures changed successfully.');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Photos $photos
     * @return array
     */
    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $photos = Photos::where('id', $request->get('id'))->get()[0];
        return [
            'status' => 1,
            'data' => $photos
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Photos $photos
     * @return array
     */
    public function edit(Photos $photos): array
    {
        return [
            "status" => 1,
            "msg" => "Photo deleted successfully",
            "data" => $photos,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photos $photo
     * @return JsonResponse
     */
    public function update(Request $request, Photos $photo)
    {
        $request->validate([
            "position" => 'required',
        ]);

        $photo->position = $request->get('position');
        $photo->save();

        return $this->sendResponse("Success", 'Pictures pos changed successfully.');
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
