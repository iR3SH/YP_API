<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $Subscriptions = Subscriptions::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $Subscriptions,
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
            "idUser" => 'required',
            "timestamp" => 'required',
            "nextCost" => 'required',
            "idAvantage" => 'required',
        ]);

        $Subscriptions = Subscriptions::create($request->all());

        return [
            "status" => 1,
            "data" => $Subscriptions,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriptions $Subscriptions
     * @return array
     */
    public function show(Subscriptions $Subscriptions): array
    {
        return [
            'status' => 1,
            'data' => $Subscriptions
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscriptions $Subscriptions
     * @return Response
     */
    public function edit(Subscriptions $Subscriptions)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Subscriptions $Subscriptions
     * @return array
     */
    public function update(Request $request, Subscriptions $Subscriptions): array
    {
        $request->validate([
            "timestamp" => 'required',
            "nextCost" => 'required',
        ]);

        $Subscriptions->update($request->all());
        return [
            "status" => 1,
            "data" => $Subscriptions,
            "msg" => "Subscriptions updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriptions $Subscriptions
     * @return array
     */
    public function destroy(Subscriptions $Subscriptions): array
    {
        $Subscriptions->delete();
        return [
            "status" => 1,
            "msg" => "Subscriptions deleted successfully",
            "data" => $Subscriptions,
        ];
    }
}
