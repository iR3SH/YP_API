<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPrefsActivities;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersPrefsActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $user = UsersPrefsActivities::all();
        return [
            "status" => 1,
            "data" => $user
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
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        $request->validate([
            'idUserPref' => 'required',
        ]);
        $userActvities = UsersPrefsActivities::create($request->all());
        return [
            'status' => 1,
            "data" => $userActvities,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return array
     */
    public function show(User $user): array
    {
        return [
            "status" => 1,
            "data" => $user
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UsersPrefsActivities $usersActivities
     * @return array
     */
    public function update(Request $request, UsersPrefsActivities $usersActivities): array
    {
        $request->validate([
            'idUserPref' => 'required',
        ]);
        $usersActivities->idUserPref = $request->get('idUserPref');
        $usersActivities->save();
        return [
            'status' => 1,
            "data" => $usersActivities,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UsersPrefsActivities $usersActivities
     * @return array
     */
    public function destroy(UsersPrefsActivities $usersActivities): array
    {
        $usersActivities->delete();
        return [
            "status" => 1,
            "data" => $usersActivities,
            "msg" => "User deleted successfully"
        ];
    }
}
