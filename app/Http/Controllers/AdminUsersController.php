<?php

namespace App\Http\Controllers;

use App\Models\AdminUsers;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index() : array
    {
        $user = AdminUsers::latest()->paginate(10);
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
            'idUser' => 'required',
            'grantedBy' => 'required',
        ]);
        $user = AdminUsers::create($request->all());
        return [
            'status' => 1,
            "data" => $user,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUsers $user
     * @return array
     */
    public function show(AdminUsers $user) : array
    {
        return [
            "status" => 1,
            "data" => $user
        ];
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
     * @return array
     */
    public function update(Request $request, AdminUsers $user) : array
    {
        $request->validate([
            'idUser' => 'required',
            'grantedBy' => 'required',
        ]);
        if(AdminUsers::where('idUser', $request->get('grantedBy')) != null)
        {
            $user->update($request->all());
            return [
                "status" => 1,
                "data" => $user,
                "msg" => "Rights updated successfully"
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
     * @param AdminUsers $user
     * @return array
     */
    public function destroy(AdminUsers $user): array
    {
        $user->delete();
        return [
            "status" => 1,
            "data" => $user,
            "msg" => "Rights deleted successfully"
        ];
    }
}
