<?php

namespace App\Http\Controllers;

use App\Models\BlockedUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $blockedUserId = null;
        $currentUserId = null;
        if($request->get('idBlockedUser') != null) {
            $blockedUserId = $request->get('idBlockedUser');
        }
        if($request->get('idUserWhoBlocked') != null) {
            $currentUserId = $request->get('idUserWhoBlocked');
        }

        if($blockedUserId != null && $currentUserId != null){
            $blockedUser = BlockedUsers::where('idBlockedUser', $blockedUserId)->where('idUserWhoBlocked', $currentUserId)->get();
            if(count($blockedUser) > 0) {
                return $this->sendResponse($blockedUser, 'Blocked User found');
            }
        }
        else if($blockedUserId == null && $currentUserId != null){
            $blockedUser = BlockedUsers::where('idUserWhoBlocked', $currentUserId)->get();
            if(count($blockedUser) > 0) {
                return $this->sendResponse($blockedUser, 'Blocked Users found');
            }
        }
        else{
            $blockedUser = BlockedUsers::all();
            if(count($blockedUser) > 0) {
                return $this->sendResponse($blockedUser, 'Blocked Users found');
            }
        }

        return $this->sendError("Blocked user not found");
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
            "idBlockedUser" => 'required',
            "idUserWhoBlocked" => 'required',
        ]);
        $verif = BlockedUsers::where('idBlockedUser', $request->get('idBlockedUser'))->where('idUserWhoBlocked', $request->get('idUserWhoBlocked'))->get();
        if(count($verif) > 0){
            return $this->sendError("Already blocked");
        }
        $blockedUsers = BlockedUsers::create($request->all());

        return $this->sendResponse($blockedUsers, "User blocked successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param BlockedUsers $blockedUser
     * @return JsonResponse
     */
    public function show(BlockedUsers $blockedUser): JsonResponse
    {
        return $this->sendResponse($blockedUser, "Blocked User founded");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlockedUsers $blockedUser
     * @return Response
     */
    public function edit(BlockedUsers $blockedUser)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        return $this->sendError('Not in Use');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlockedUsers $blockedUser
     * @return JsonResponse
     */
    public function destroy(BlockedUsers $blockedUser): JsonResponse
    {
        $blockedUser->delete();
        return $this->sendResponse($blockedUser, 'User unblocked successfully !');
    }
}
