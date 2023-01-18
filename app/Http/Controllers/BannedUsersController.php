<?php

namespace App\Http\Controllers;

use App\Models\BannedUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $bannedUsers = BannedUsers::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $bannedUsers,
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
            "timestamp" => 'required',
            "reason" => 'required',
            "idUser" => 'required',
            "idAdmin" => 'required',
        ]);

        $bannedUser = BannedUsers::create($request->all());

        return [
            "status" => 1,
            "data" => $bannedUser,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param BannedUsers $bannedUsers
     * @return array
     */
    public function show(BannedUsers $bannedUsers): array
    {
        return [
          'status' => 1,
          'data' => $bannedUsers
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BannedUsers $bannedUsers
     * @return Response
     */
    public function edit(BannedUsers $bannedUsers)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param BannedUsers $bannedUsers
     * @return array
     */
    public function update(Request $request, BannedUsers $bannedUsers): array
    {
        $request->validate([
            "timestamp" => 'required',
            "reason" => 'required',
            "idUser" => 'required',
            "idAdmin" => 'required',
            "isLifeTime" => 'required',
        ]);

        $bannedUsers->update($request->all());
        return [
            "status" => 1,
            "data" => $bannedUsers,
            "msg" => "BannedUser updated successfully",
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BannedUsers $bannedUsers
     * @return array
     */
    public function destroy(BannedUsers $bannedUsers): array
    {
        $bannedUsers->delete();
        return [
            "status" => 1,
            "msg" => "BannedUser deleted successfully",
            "data" => $bannedUsers,
        ];
    }
}
