<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/conversations",
     *      operationId="indexConversations",
     *      tags={"Conversations"},
     *      summary="Get list of Conversations from One User",
     *      description="Returns list of Conversations from One User",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who has conversation",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns list of Conversations from One User
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'iduser' => 'required'
        ]);
        $conversationFirstUser = Conversations::where('idFirstUser', $request->get('idUser'))->get();
        $conversationSecondUser = Conversations::where('idSecondUser', $request->get('idUser'))->get();
        $array = [];
        if(count($conversationFirstUser) > 0) {
            $array->array_push($conversationFirstUser);
        }
        if(count($conversationSecondUser) > 0) {
            $array->array_push($conversationSecondUser);
        }
        return $this->sendResponse($array, "Conversations from User sended");
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
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/api/conversations",
     *      operationId="storeConversations",
     *      tags={"Conversations"},
     *      summary="Create a  Conversations",
     *      description="Returns the created Conversations",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idFirstUser",
     *         in="query",
     *         description="iid of the first User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idSecondUser",
     *         in="query",
     *         description="id of the second User",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns the created Conversations
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idFirstUser" => 'required',
            "idSecondUser" => 'required',
        ]);
        $conversationCheck = Conversations::where('idFirstUser', $request->get('idFirstUser'))->where('idSecondUser', $request->get('idSecondUser'))->get();
        if(count($conversationCheck) == 0){
            $conversationCheck = Conversations::where('idFirstUser', $request->get('idSecondUser'))->where('idSecondUser', $request->get('idFirstUser'))->get();
            if(count($conversationCheck) == 0){
                $conversation = Conversations::create($request->all());
                return $this->sendResponse($conversation, "Conversation created !");
            }
        }

        return $this->sendError("Conversation already exist !");
    }

    /**
     * Display the specified resource.
     *
     * @param Conversations $conversation
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/conversations/{id}",
     *      operationId="showConversations",
     *      tags={"Conversations"},
     *      summary="Get a Conversations",
     *      description="Returns a Conversations",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the conversation",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a Conversations
     */
    public function show(Conversations $conversation): JsonResponse
    {
        return $this->sendResponse($conversation, "Conversation finded");
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
     * @return JsonResponse
     */
    public function update(Request $request, Conversations $conversation): JsonResponse
    {
        return $this->sendError("Conversation can't be updated, only the message can be updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Conversations $conversation
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/conversations/{id}",
     *      operationId="deleteConversations",
     *      tags={"Conversations"},
     *      summary="Get a Conversations",
     *      description="Returns a Conversations",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the conversation",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a Conversations
     */
    public function destroy(Conversations $conversation): JsonResponse
    {
        $conversation->delete();

        return $this->sendResponse($conversation, "Conversation deleted successfully");
    }
}
