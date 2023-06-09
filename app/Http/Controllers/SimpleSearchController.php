<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SimpleSearchController extends Controller
{
    /**
     * Make an SimpleSearch for a specified User.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/simpleSearch",
     *      operationId="showsimpleSearch",
     *      tags={"SimpleSearch"},
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
        try {
            $finalDic = [];
            $allUsers = User::where('id', '!=', $request->get('idUser'))->get();
            $user = User::where('id', $request->get('idUser'))->get()[0];
            $userPref = UsersPreferences::where('idUser', $request->get('idUser'))->get()[0];
            if (count($allUsers) > 0) {
                $userActivities = UsersActivities::where('idUser', $request->get('idUser'))->get();
                if(count($userActivities) > 0) {
                    foreach ($allUsers as $users) {
                        if($userPref->getAttribute('genderPref') == $users->getAttribute('gender')) {
                            if ($this->canBeSearched($users, $user)) {
                                $userToCheckAct = UsersActivities::where('idUser', $users->getAttribute('id'))->get();
                                $score = 0;
                                foreach ($userActivities as $act) {
                                    foreach ($userToCheckAct as $checkAct) {
                                        if ($act->getAttribute('idActivity') == $checkAct->getAttribute('idActivity')) {
                                            $score += 10;
                                            break;
                                        }
                                    }
                                }
                                $score += $this->getBonusFromPremiumUser($users);
                                $finalDic += [$users->getAttribute('id') => $score];

                            }
                        }
                    }
                }
                else
                {
                    foreach ($allUsers as $users) {
                        $score = 0;
                        if($this->canBeSearched($users, $user)) {
                            if ($userPref->getAttribute('genderPref') == $users->getAttribute('gender')) {
                                $score += $this->getBonusFromPremiumUser($users);
                                $finalDic += [$users->getAttribute('id') => $score];
                            }
                        }
                    }
                }
                if (count($finalDic) > 0) {
                    arsort($finalDic);
                    $count = 0;
                    $dicToSend =  [];

                    foreach ($finalDic as $key => $value){
                        if($count < 10){
                            $userToPush = User::where('id', $key)->get()[0];
                            $Uactivies = UsersActivities::where('idUser', $userToPush->id)->get();
                            $activities = [];
                            if(count($Uactivies) > 0)
                            {
                                foreach ($Uactivies as $uactivity) {
                                    $act = Activities::where('id',$uactivity->idActivity)->get()[0];
                                    array_push($activities, $act);
                                }
                            }
                            $activities_topush = $this->GetUserActivities($activities);
                            if($activities_topush != null) {
                                array_push($dicToSend, [$userToPush, $activities_topush]);
                            }
                            else {
                                array_push($dicToSend, $userToPush);
                            }
                            $count++;
                        }
                        else{
                            break;
                        }
                    }
                    return $this->sendResponse($dicToSend, "Users founded");
                }
            }
            return $this->sendError("No other user has be found");
        }
        catch (\Exception $ex){
            return $this->sendError("Fatal Error", [ $ex->getMessage(), $ex->getTrace()]);
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
