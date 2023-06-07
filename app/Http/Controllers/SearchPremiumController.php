<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use App\Models\UsersPrefsActivities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchPremiumController extends Controller
{
    /**
     * Make an SimpleSearch for a specified User.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/searchPremium",
     *      operationId="showSearchPremium",
     *      tags={"SearchPremium"},
     *      summary="Get list of User",
     *      description="Returns list of User",
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
     * Returns the List of User
     */
    public function index(Request $request): JsonResponse
    {
        $allUsers = null;
        try {
            $currentUser = User::where('id', $request->get('idUser'))->get()[0];
            $currentUserPref = UsersPreferences::where('idUser', $currentUser->id)->get()[0];
            $currentUserFilters = UsersPrefsActivities::where('idUserPref', $currentUserPref->id)->get();
            if(count($currentUserFilters) == 0){
               return (new SimpleSearchController)->index($request);
            }
            $currentUserAct = UsersActivities::where('idUser', $currentUser->id)->get();
            $allUsers = $this->getUserByPremiumFilter($currentUser);
            $userToPush = [];
            if(count($allUsers) > 0){
                foreach($allUsers as $key => $value){
                    $userToCheck = User::where('id', array_keys($value)[0])->get()[0];
                    $userToCheckAct = UsersActivities::where('idUser', $userToCheck->id)->get();
                    $score = 0;
                    $score += $this->getBonusFromPremiumUser($userToCheck);
                    foreach($currentUserAct as $act){
                        foreach ($userToCheckAct as $activity){
                            if($act->idActivity == $activity->idActivity){
                                $score += 10;
                            }
                        }
                    }
                    foreach ($value as $keys => $values){
                        array_replace($allUsers[$key],  [$keys => $values + $score]);
                    }
                    foreach ($value as $keys => $values){
                        $usertosearch = User::where('id', $keys)->get()[0];
                        array_push($userToPush, $usertosearch);
                    }
                }
            }
            return $this->sendResponse($userToPush, "Users Found by PremiumFilter");
        }
        catch (\Exception $ex){
            return $this->sendError("Fatal Error");
        }
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
