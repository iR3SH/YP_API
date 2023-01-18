<?php

namespace App\Http\Controllers;

use App\Models\ReportedUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $reportedUsers = ReportedUsers::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $reportedUsers,
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

        $reportedUsers = ReportedUsers::create($request->all());

        return [
            "status" => 1,
            "data" => $reportedUsers,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param ReportedUsers $reportedUsers
     * @return array
     */
    public function show(ReportedUsers $reportedUsers): array
    {
        return [
            'status' => 1,
            'data' => $reportedUsers
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportedUsers $reportedUsers
     * @return Response
     */
    public function edit(ReportedUsers $reportedUsers)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param ReportedUsers $reportedUsers
     * @return array
     */
    public function update(Request $request, ReportedUsers $reportedUsers): array
    {
        $request->validate([
            "reason" => 'required',
            "content" => 'required',
            "reportedUser" => 'required',
            "userWhoReported" => 'required',
            "isClosed" => 'required',
        ]);

        $reportedUsers->update($request->all());
        return [
            "status" => 1,
            "data" => $reportedUsers,
            "msg" => "ReportedUser updated successfully",
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportedUsers $reportedUsers
     * @return array
     */
    public function destroy(ReportedUsers $reportedUsers): array
    {
        $reportedUsers->delete();
        return [
            "status" => 1,
            "msg" => "ReportedUser deleted successfully",
            "data" => $reportedUsers,
        ];
    }
}
