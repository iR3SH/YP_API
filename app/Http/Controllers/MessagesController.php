<?php

namespace App\Http\Controllers;

use App\Models\Conversations;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/messages",
     *      operationId="indexMessages",
     *      tags={"Messages"},
     *      summary="Get list of Messages from One Conversation",
     *      description="Returns list of Messages from One Conversation",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who has conversation",
     *         required=false,
     *      ),
     *      @OA\Parameter(
     *         name="idConversation",
     *         in="query",
     *         description="id of the conversation",
     *         required=false,
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
     * Returns the list of message from one User and one conversation
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'nullable',
            'idConversation' => 'nullable'
        ]);
        $messages = null;
        $user = null;
        $conversation = null;
        if($request->get('idUser') != null){
            $user = User::where('id', $request->get('idUser'))->get();
            if(count($user) == 0) {
                return $this->sendError("The specified user wasn't found");
            }
        }

        if($request->get('idConversation') != null){
            $conversation = Conversations::where('id', $request->get('idConversation'))->get();
            if(count($conversation) == 0){
                return $this->sendError("The specified conversation wasn't found");
            }
        }

        if($user != null && $conversation != null){
            $messages = Messages::where('idUser', $user[0]->id)->where('idConversation', $conversation[0]->id)->get();
            if(count($messages) == 0) {
                $this->sendError("Message wasn't found for the specified conversation and User");
            }
        }
        else if(count($messages) != 0 && count($conversation) == 0){
            $messages = Messages::where('idUser', $user[0]->id)->get();
            if(count($messages) == 0) {
                $this->sendError("Message wasn't found for the specified conversation and User");
            }
        }
        else if(count($messages) == 0 && count($conversation) != 0){
            $messages = Messages::where('idConversation', $conversation[0]->id)->get();
            if(count($messages) == 0) {
                $this->sendError("Message wasn't found for the specified conversation and User");
            }
        }

        return $this->sendResponse($messages, "Message from conversation has been found");
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
     *      path="/api/messages",
     *      operationId="storeMessages",
     *      tags={"Messages"},
     *      summary="Create a new message",
     *      description="Returns the stored message",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="idConversation",
     *         in="query",
     *         description="id of the conversation",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="content of the message",
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
     * Returns the stored message
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "idConversation" => 'required',
            "content" => 'required',
            "idUser" => 'required',
        ]);

        $message = Messages::create($request->all());

        return $this->sendResponse($message, "Message has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param Messages $message
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/messages/{id}",
     *      operationId="showMessages",
     *      tags={"Messages"},
     *      summary="Get one message by Id",
     *      description="Returns the message",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Message",
     *         required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     *  )
     *
     * Returns the message
     */
    public function show(Messages $message): JsonResponse
    {
        return $this->sendResponse($message, "Message found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Messages $message
     * @return
     */
    public function edit(Messages $message)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param Messages $message
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/messages/{id}",
     *      operationId="updateMessages",
     *      tags={"Messages"},
     *      summary="Update the content of one message",
     *      description="Returns the updated message",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the message",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="content of the message",
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
     * Returns the updated message
     */
    public function update(Request $request, Messages $message): JsonResponse
    {
        $request->validate([
            "content" => 'required',
        ]);

        $message->update($request->all());
        return $this->sendResponse($message, "The message has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Messages $message
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/messages/{id}",
     *      operationId="destroyMessages",
     *      tags={"Messages"},
     *      summary="Delete one message by Id",
     *      description="Returns the deleted message",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the Message",
     *         required=true,
     *      ),
     *     @OA\Response(
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
     * Returns the deleted message
     */
    public function destroy(Messages $message): JsonResponse
    {
        $message->delete();
        return $this->sendResponse($message, "Message deleted successfully");
    }
}
