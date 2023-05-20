<?php

namespace App\Http\Controllers;

use App\Models\AdminUsers;
use App\Models\Conversations;
use App\Models\Likes;
use App\Models\Messages;
use App\Models\ReportedUsers;
use App\Models\SuperLikes;
use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AdminPanelController extends Controller
{
    /**
     * Make an SimpleSearch for a specified User.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/adminPanel",
     *      operationId="showAdminPanel",
     *      tags={"AdminPanel"},
     *      summary="Get list of User's Stats",
     *      description="Returns list of User's Stats",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id from the current User",
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
     * Returns the List of User's Stats
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        $array = [];

        $userInfo = auth('sanctum')->user();
        if(!$this->isAdmin($userInfo->id)){
            return $this->sendError('Only Admin User');
        }

        $user = User::where('id', $request->get('idUser'))->get();
        if(count($user) > 0){
            $user = $user[0];
            $likesGivenCount = count(Likes::where('idUserWhoLiked', $user->id)->get());
            $likesReceivedCount = count(Likes::where('idUserWhoBeLiked', $user->id)->get());
            $superLikeGivenCount = count(SuperLikes::where('idUserWhoLiked', $user->id)->get());
            $superLikeReceivedCount = count(SuperLikes::where('idUserWhoBeLiked', $user->id)->get());
            $conversationsCount = count(Conversations::where('idFirstUser', $user->id)->get());
            $conversationsCount += count(Conversations::where('idSecondUser', $user->id)->get());
            $messagesCount = count(Messages::where('idUser', $user->id)->get());
            $reportCount = count(ReportedUsers::where('reportedUser', $user->id)->get());
            $activitiesCount = count(UsersActivities::where('idUser', $user->id)->get());
            $array = array(
                'likesGivenCount' => $likesGivenCount,
                'likesReceivedCount' => $likesReceivedCount,
                'superLikeGivenCount' => $superLikeGivenCount,
                'superLikeReceivedCount' => $superLikeReceivedCount,
                'conversationsCount' => $conversationsCount,
                'messagesCount' => $messagesCount,
                'reportCount' => $reportCount,
                'activitiesCount' => $activitiesCount
            );
        }
        else
        {
            return $this->sendError('No User was found');
        }
        return $this->sendResponse($array, 'Stats generated');
    }
    public function create(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
    public function store(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
    public function show(Request $request) : JsonResponse
    {
        return $this->sendError("Not Used");
    }

    public function edit() : JsonResponse
    {
        return $this->sendError("Not Used");
    }

    public function update() : JsonResponse
    {
        return $this->sendError("Not Used");
    }

    public function destroy(): JsonResponse
    {
        return $this->sendError("Not Used");
    }
}
