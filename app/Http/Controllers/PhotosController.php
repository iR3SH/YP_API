<?php

namespace App\Http\Controllers;

use App\Models\Photos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/photos",
     *      operationId="indexPhotos",
     *      tags={"Photos"},
     *      summary="Get list of Photos from One User",
     *      description="Returns list of Photos from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns list of Photos from One User
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        $photos = Photos::where('idUser', $request->get('idUser'))->get();

        return $this->sendResponse($photos, "User photos founded");
    }

    /**
     * Show the form for creating a new resource.
     *
     *
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
    /**
     * @OA\Post(
     *      path="/api/photos",
     *      operationId="storePhotos",
     *      tags={"Photos"},
     *      summary="Get list of Photos from One User",
     *      description="Returns list of Photos from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="image",
     *                     type="file",
     *                ),
     *                 @OA\Property(
     *                     description="Id of the User",
     *                     property="idUser",
     *                     type="integer",
     *                ),
     *                 required={"image"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns list of Photos from One User
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
     * @param Photos $photo
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/photos/{id}",
     *      operationId="showPhotos",
     *      tags={"Photos"},
     *      summary="Get list of Photos from One User",
     *      description="Returns list of Photos from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id from the Photo",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns the Photo from One User
     */
    public function show(Photos $photo) : JsonResponse
    {
        return $this->sendResponse($photo, "Photo found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Photos $photo
     * @return array
     */
    public function edit(Request $request, Photos $photo)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photos $photo
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/photos/{id}",
     *      operationId="updatePhotos",
     *      tags={"Photos"},
     *      summary="Get list of Photos from One User",
     *      description="Returns list of Photos from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id from the Photo",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="position",
     *         in="query",
     *         description="position from the Photo",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns the updated Photo
     */
    public function update(Request $request, Photos $photo)
    {
        $request->validate([
            "position" => 'required',
        ]);

        $photo->position = $request->get('position');
        $photo->save();

        return $this->sendResponse($photo, 'Pictures pos changed successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Photos $photo
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/photos/{id}",
     *      operationId="destroyPhotos",
     *      tags={"Photos"},
     *      summary="Delete the photo",
     *      description="Returns the deleted Photos from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id from the Photo",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns the deleted Photos from One User
     */
    public function destroy(Photos $photo): JsonResponse
    {
        File::delete(public_path().'/users/'.$photo->fileName);
        $photo->delete();
        return $this->sendResponse($photo, "Photo deleted successfully");
    }
}
