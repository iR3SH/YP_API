<?php

namespace App\Http\Controllers;

use App\Models\BlockedUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $blockedUsers = BlockedUsers::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $blockedUsers,
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
            "reason" => 'required',
            "content" => 'required',
            "reportedUser" => 'required',
            "userWhoReported" => 'required',
        ]);

        $blockedUsers = BlockedUsers::create($request->all());

        return [
            "status" => 1,
            "data" => $blockedUsers,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param BlockedUsers $blockedUsers
     * @return array
     */
    public function show(BlockedUsers $blockedUsers): array
    {
        return [
            'status' => 1,
            'data' => $blockedUsers
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BlockedUsers $blockedUsers
     * @return Response
     */
    public function edit(BlockedUsers $blockedUsers)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param BlockedUsers $blockedUsers
     * @return array
     */
    public function update(Request $request, BlockedUsers $blockedUsers): array
    {
        $request->validate([
            "reason" => 'required',
            "content" => 'required',
            "reportedUser" => 'required',
            "userWhoReported" => 'required',
            "isClosed" => 'required',
        ]);

        $blockedUsers->update($request->all());
        return [
            "status" => 1,
            "data" => $blockedUsers,
            "msg" => "BlockedUser updated successfully",
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BlockedUsers $blockedUsers
     * @return array
     */
    public function destroy(BlockedUsers $blockedUsers): array
    {
        $blockedUsers->delete();
        return [
            "status" => 1,
            "msg" => "BlockedUser deleted successfully",
            "data" => $blockedUsers,
        ];
    }
}
