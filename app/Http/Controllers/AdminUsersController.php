<?php

namespace App\Http\Controllers;

use App\Models\AdminUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/adminUsers",
     *      operationId="indexAdminUsers",
     *      tags={"AdminUsers"},
     *      summary="Get list of AdminUsers",
     *      description="Returns list of AdminUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who ask the request",
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
     * Returns list of AdminUsers
     */
    public function index(Request $request) : JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        if($this->isAdminUser($request->get('idUser'))) {
            $user = AdminUsers::all();
            return $this->sendResponse($user, "Authorised to see list of Admin users");
        }
        else {
            return $this->sendError("Request not found");
        }
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
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/api/adminUsers",
     *      operationId="storeAdminUsers",
     *      tags={"AdminUsers"},
     *      summary="Grant an Users",
     *      description="Returns a AdminUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User to be granted",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="grantedBy",
     *         in="query",
     *         description="id of the AdminUser",
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
     * Returns a AdminUsers
     */
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'idUser' => 'required',
            'grantedBy' => 'required',
        ]);
        if($this->isAdminUser($request->get('grantedBy'))) {
            $user = AdminUsers::create($request->all());
            return $this->sendResponse($user, "User granted successfully");
        }
        else{
            return $this->sendError("Request not found");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUsers $user
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/adminUsers/{idUser}",
     *      operationId="showAdminUsers",
     *      tags={"AdminUsers"},
     *      summary="Get the AdminUser",
     *      description="Returns the AdminUser",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
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
     * Returns the AdminUser
     */
    public function show(AdminUsers $user) : JsonResponse
    {
        return $this->sendResponse($user, "Result");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AdminUsers $user
     * @return Response
     */
    public function edit(AdminUsers $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AdminUsers $user
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/adminUsers/{idUser}",
     *      operationId="updateAdminUsers",
     *      tags={"AdminUsers"},
     *      summary="Update the AdminUser",
     *      description="Returns the AdminUser",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
     *         description="id of the User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="grantedBy",
     *         in="query",
     *         description="id of the AdminUser who ask the request",
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
     * Returns the AdminUser
     */
    public function update(Request $request, AdminUsers $user) : JsonResponse
    {
        $request->validate([
            'grantedBy' => 'required',
        ]);
        if($this->isAdminUser($request->get('grantedBy')))
        {
            $user->update($request->all());
            return $this->sendResponse($user, "Rights updated successfully");
        }
        else
        {
            return $this->sendError("Request not found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdminUsers $user
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/adminUsers/{idUser}",
     *      operationId="deleteAdminUsers",
     *      tags={"AdminUsers"},
     *      summary="Delete the AdminUser",
     *      description="Returns the AdminUser",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="path",
     *         description="id of the User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="grantedBy",
     *         in="query",
     *         description="id of the AdminUser who ask the request",
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
     * Returns the AdminUser
     */
    public function destroy(Request $request, AdminUsers $user): JsonResponse
    {
        $request->validate([
            'grantedBy' => 'required',
        ]);
        if($this->isAdminUser($request->get('grantedBy')))
        {
            $user->delete();
            return $this->sendResponse($user, "Rights deleted successfully");
        }
        else
        {
            return $this->sendError("Request not found");
        }
    }
}
