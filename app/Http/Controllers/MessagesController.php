<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $messages = Messages::lastest()->paginate(10);

        return [
            "status" => 1,
            "data" => $messages,
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
            "idConversation" => 'required',
            "content" => 'required',
            "idUser" => 'required',
        ]);

        $messages = Messages::create($request->all());

        return [
            "status" => 1,
            "data" => $messages,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Messages $messages
     * @return array
     */
    public function show(Messages $messages): array
    {
        return [
            'status' => 1,
            'data' => $messages
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Messages $messages
     * @return Response
     */
    public function edit(Messages $messages)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Messages $messages
     * @return array
     */
    public function update(Request $request, Messages $messages): array
    {
        $request->validate([
            "content" => 'required',
        ]);

        $messages->update($request->all());
        return [
            "status" => 1,
            "data" => $messages,
            "msg" => "Messages updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Messages $messages
     * @return array
     */
    public function destroy(Messages $messages): array
    {
        $messages->delete();
        return [
            "status" => 1,
            "msg" => "Messages deleted successfully",
            "data" => $messages,
        ];
    }
}
