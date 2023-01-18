<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $conversation = Conversations::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $conversation,
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
            "idFirstUser" => 'required',
            "idSecondUser" => 'required',
        ]);

        $conversation = Conversations::create($request->all());

        return [
            "status" => 1,
            "data" => $conversation,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Conversations $likes
     * @return array
     */
    public function show(Conversations $conversation): array
    {
        return [
            'status' => 1,
            'data' => $conversation
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Conversations $conversation
     * @return Response
     */
    public function edit(Conversations $conversation)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Conversations $conversation
     * @return array
     */
    public function update(Request $request, Conversations $conversation): array
    {
        $request->validate([
            "messages" => 'required',
        ]);

        $conversation->update($request->all());
        return [
            "status" => 1,
            "data" => $conversation,
            "msg" => "Conversation updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Conversations $conversation
     * @return array
     */
    public function destroy(Conversations $conversation): array
    {
        $conversation->delete();
        return [
            "status" => 1,
            "msg" => "Conversation deleted successfully",
            "data" => $conversation,
        ];
    }
}
