<?php

namespace App\Http\Controllers;

use App\Models\Avantages;
use Illuminate\Http\Request;

class AvantagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $Avantages = Avantages::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $Avantages,
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
            "canUseExtraFilter" => 'required',
            "canSeeWhoLiked" => 'required',
            "canReceiveDailyExtraLike" => 'required',
            "canGoBack" => 'required',
            "isPremiumProfile" => 'required',
            "price" => 'required',
        ]);

        $Avantages = Avantages::create($request->all());

        return [
            "status" => 1,
            "data" => $Avantages,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Avantages $Avantages
     * @return array
     */
    public function show(Avantages $Avantages): array
    {
        return [
            'status' => 1,
            'data' => $Avantages
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Avantages $Avantages
     * @return Response
     */
    public function edit(Avantages $Avantages)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Avantages $Avantages
     * @return array
     */
    public function update(Request $request, Avantages $Avantages): array
    {
        $request->validate([
            "canUseExtraFilter" => 'required',
            "canSeeWhoLiked" => 'required',
            "canReceiveDailyExtraLike" => 'required',
            "canGoBack" => 'required',
            "isPremiumProfile" => 'required',
            "price" => 'required',
        ]);

        $Avantages->update($request->all());
        return [
            "status" => 1,
            "data" => $Avantages,
            "msg" => "Avantages updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Avantages $Avantages
     * @return array
     */
    public function destroy(Avantages $Avantages): array
    {
        $Avantages->delete();
        return [
            "status" => 1,
            "msg" => "Avantages deleted successfully",
            "data" => $Avantages,
        ];
    }
}
