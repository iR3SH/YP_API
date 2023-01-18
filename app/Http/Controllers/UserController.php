<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index() : array
    {
        $user = User::latest()->paginate(10);
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
    public function store(Request $request) : array
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'lastName' => 'required',
            'phoneNumber' => 'required',
            'gender' => 'required',
            'city' => 'required',
        ]);
        $user = User::create($request->all());
        return [
            'status' => 1,
            "data" => $user,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return array
     */
    public function show(User $user) : array
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
     * @param User $user
     * @return array
     */
    public function update(Request $request, User $user) : array
    {
        $request->validate([
            'email' => 'required',
            'phoneNumber' => 'required',
            'password' => 'required',
        ]);
        $user->update($request->all());
        return [
          "status" => 1,
          "data" => $user,
           "msg" => "User updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return array
     */
    public function destroy(User $user): array
    {
        $user->delete();
        return [
          "status" => 1,
          "data" => $user,
          "msg" => "User deleted successfully"
        ];
    }
}
