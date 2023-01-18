<?php

namespace App\Http\Controllers;

use App\Models\BuyLogs;
use Illuminate\Http\Request;

class BuyLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $buyLogs = BuyLogs::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $buyLogs,
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
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $buyLogs = BuyLogs::create($request->all());

        return [
            "status" => 1,
            "data" => $buyLogs,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param BuyLogs $buyLogs
     * @return array
     */
    public function show(BuyLogs $buyLogs): array
    {
        return [
            'status' => 1,
            'data' => $buyLogs
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BuyLogs $buyLogs
     * @return Response
     */
    public function edit(BuyLogs $buyLogs)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param BuyLogs $buyLogs
     * @return array
     */
    public function update(Request $request, BuyLogs $buyLogs): array
    {
        $request->validate([
            "idUserWhoLiked" => 'required',
            "idUserWhoBeLiked" => 'required',
        ]);

        $buyLogs->update($request->all());
        return [
            "status" => 1,
            "data" => $buyLogs,
            "msg" => "BuyLogs updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BuyLogs $buyLogs
     * @return array
     */
    public function destroy(BuyLogs $buyLogs): array
    {
        $buyLogs->delete();
        return [
            "status" => 1,
            "msg" => "BuyLogs deleted successfully",
            "data" => $buyLogs,
        ];
    }
}
