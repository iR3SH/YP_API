<?php

namespace App\Http\Controllers;

use App\Models\ActivitiesType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivitiesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $activitiesType = ActivitiesType::all();
        return [
            "status" => 1,
            "data" => $activitiesType
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
            'name' => 'required',
        ]);
        $activitiesType = ActivitiesType::create($request->all());
        return [
            'status' => 1,
            "data" => $activitiesType,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param ActivitiesType $activitiesType
     * @return array
     */
    public function show(ActivitiesType $activitiesType): array
    {
        return [
            "status" => 1,
            "data" => $activitiesType
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ActivitiesType $activitiesType
     * @return Response
     */
    public function edit(ActivitiesType $activitiesType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ActivitiesType $activitiesType
     * @return array
     */
    public function update(Request $request, ActivitiesType $activitiesType): array
    {
        $request->validate([
            'name' => 'required',
        ]);
        $activitiesType->title = $request->get('name');
        $activitiesType->save();
        return [
            'status' => 1,
            "data" => $activitiesType,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ActivitiesType $activitiesType
     * @return array
     */
    public function destroy(ActivitiesType $activitiesType): array
    {
        $activitiesType->delete();
        return [
            "status" => 1,
            "data" => $activitiesType,
            "msg" => "ActivitiesType deleted successfully"
        ];
    }
}
