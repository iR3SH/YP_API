<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersPreferences;
use Illuminate\Http\Request;

class UsersPreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index() // Avoir tout les UsersPreferences
    {
        $preferencies = UsersPreferences::latest()->paginate(10);
        return [
          "status" => 1,
          "data" => $preferencies,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
    public function store(Request $request)// Créer un UsersPreferences
    {
        $request->validate([
            "activities" => 'string',
            "musicsStyles" => 'string',
            "redFlags" => 'string',
            "languages" => 'string',
            "moviePref" => 'string',
            "genderPref" => 'string',
            "distancePref" => 'integer',
            "idUser" => 'required',

        ]);

        if(User::where('id', $request->get('idUser')) != null)
        {
            $user = UsersPreferences::create($request->all());
            return [
              "status" => 1,
              "data" =>  $user,
              "msg" => "UserPreferences created successfully",
            ];
        }
        else
        {
            return [
                "status" => 500,
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsersPreferences  $usersPreferences
     * @return \Illuminate\Http\Response
     */
    public function show(UsersPreferences $usersPreferences)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UsersPreferences  $usersPreferences
     * @return \Illuminate\Http\Response
     */
    public function edit(UsersPreferences $usersPreferences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function update(Request $request)// Mettre à jour un UsersPreferences
    {
        $request->validate([
            "activities" => 'string',
            "musicsStyles" => 'string',
            "redFlags" => 'string',
            "languages" => 'string',
            "moviePref" => 'string',
            "genderPref" => 'string',
            "distancePref" => 'integer',
            "idUser" => 'required',

        ]);

        if(UsersPreferences::where('id', $request->get('idUser')) != null)
        {
            $usersPreferences->update($request->all());
            return [
                "status" => 1,
                "data" =>  $usersPreferences,
                "msg" => "UserPreferences updated successfully",
            ];
        }
        else
        {
            return [
                "status" => 500,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request) // Delete un UsersPreferences
    {
        $request->validate([
            "id" => 'required',

        ]);
        $usersPreferences = UsersPreferences::find($request->get('id'));

        if($usersPreferences != null) {
            $usersPreferences->delete();
            return [
                "status" => 200,
            ];
        }
        else
        {
            return [
                "status" => 403,
            ];
        }
    }
}
