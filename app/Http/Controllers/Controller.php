<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\AdminUsers;
use App\Models\BannedUsers;
use App\Models\BlockedUsers;
use App\Models\Consoles;
use App\Models\Conversations;
use App\Models\Dislikes;
use App\Models\Jeux;
use App\Models\Likes;
use App\Models\Messages;
use App\Models\MoviesType;
use App\Models\Plateformes;
use App\Models\Sorties;
use App\Models\Sports;
use App\Models\Subscriptions;
use App\Models\SuperLikes;
use App\Models\TagsModel;
use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use App\Models\UsersPrefsActivities;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="YP API", version="2.5"),
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearer_token",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return JsonResponse
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }


    /**
     *
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */

    public function sendError($error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Destroy Match Relation
     * @param $idUser
     * @param $idUser2
     * @return void
     */
    public function destroyMatchRelation($idUser, $idUser2){
        $conversation = Conversations::where('idFirstUser', $idUser)->where('idSecondUser', $idUser2)->get();
        if(count($conversation) == 0)
        {
            $conversation = Conversations::where('idFirstUser', $idUser2)->where('idSecondUser', $idUser)->get();
            if(count($conversation) > 0){
                $messages = Messages::where('idConversation', $conversation->id)->get();
                if(count($messages) > 0){
                    foreach ($messages as $message){
                        $message->delete();
                    }
                }
            }
            $conversation->delete();
        }
        else{
            $messages = Messages::where('idConversation', $conversation->id)->get();
            if(count($messages) > 0){
                foreach ($messages as $message){
                    $message->delete();
                }
            }
            $conversation->delete();
        }
    }
    public function checkIfBanned($idUser) : bool {
        $userBanned = BannedUsers::where('idUser', $idUser)->get();
        if(count($userBanned) > 0){
            return true;
        }
        return false;
    }

    public function isAdminUser($idUser) : bool {
        $admin = AdminUsers::where('idUser', $idUser)->get();
        if(count($admin) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @param User $userToTest Potential proposed profile
     * @param User $currentUser User which connected and trying to find someone
     * @return bool
     */
    public function canBeSearched(User $userToTest, User $currentUser){
        if($userToTest->id == $currentUser->id)
        {
            return false;
        }
        $bannedUser = BannedUsers::where('idUser', $userToTest->id)->get();
        if(count($bannedUser) != 0){
            return false;
        }

        $blockedUser = BlockedUsers::where('idUserWhoBlocked', $currentUser->id)->where('idBlockedUser', $userToTest->id)->get();
        if(count($blockedUser) != 0){
            return false;
        }
        $blockedUser2 = BlockedUsers::where('idUserWhoBlocked', $userToTest->id)->where('idBlockedUser', $currentUser->id)->get();
        if(count($blockedUser2) != 0){
            return false;
        }

        $disliked = Dislikes::where('idWhoDisliked', $currentUser->id)->where('idWhoBeDisliked', $userToTest->id)->get();
        if(count($disliked) != 0){
            return false;
        }

        $liked = Likes::where('idUserWhoLiked', $currentUser->id)->where('idUserWhoBeLiked', $userToTest->id)->get();
        if(count($liked) != 0){
            return false;
        }

        $superLiked = SuperLikes::where('idUserWhoLiked', $userToTest->id)->where('idUserWhoBeLiked', $currentUser->id)->get();
        if(count($superLiked) != 0){
            return false;
        }

        return true;
    }
    /**
     *
     * Return the list with specified Premium Filters
     *
     * @param User $user
     * @return array
     */
    public function getUserByPremiumFilter(User $user) : array
    {
        // Variable
        $userArray = [];
        $userPref = UsersPreferences::where('idUser', $user->id)->get()[0];
        $userFilters = UsersPrefsActivities::where('idUserPref', $userPref->id)->get();
        $count = 0;
        // Verification for each selected filter
        foreach($userFilters as $filter){
            $userActivities = UsersActivities::where('idActivity', $filter->idActivity)->where('idUser', '!=', $user->id)->get();

            // For each registered activity where equals selected filter
            foreach($userActivities as $activity) {
                $userToCheck = User::where('id', $activity->idUser)->get()[0];
                $score = 10;
                // Check if it's the good gender
                if($userToCheck->gender != $userPref->genderPref) {
                    // if user can be searched
                    if ($this->canBeSearched($userToCheck, $user)) {
                        if (array_key_exists($userToCheck->id, $userArray)) {
                            $userArray[$userToCheck->id] += $score;
                        } else {
                            $userArray += [$userToCheck->id => $score];
                        }
                    }
                }
            }
        }
        $returnArray = [];
        if(count($userArray) > 0){
            arsort($userArray);
            foreach($userArray as $key => $value){
                if($count < 10){
                    array_push($returnArray, [$key => $value]);
                    $count++;
                }
                else
                {
                    break;
                }
            }
        }
        return $returnArray;
    }

    /**
     * Return bonus point for Premium User's
     * @param User $user
     * @return int
     */
    public function getBonusFromPremiumUser(User $user) : int
    {
        $subscription = Subscriptions::where('idUser', $user->id)->get();
        if(count($subscription) > 0){
            if($subscription[0]->idAvantage == 2){
                return 20;
            }
            else if($subscription[0]->idAvantage == 3){
                return 50;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }

    public function isAdmin(int $idUser):bool
    {
        $adminCheck = AdminUsers::where('idUser', $idUser)->get();
        return count($adminCheck) == 0;
    }
    public function GetUserActivities(array $activities): array
    {
        $returnsData =  [];
        if(count($activities) > 0 && $activities != null) {
            foreach ($activities as $activity) {
                $activity_to_push = [];
                $tag = null;
                array_push($activity_to_push, ["idActivity" => $activity->id], ["idType" => $activity->type]);
                switch ($activity->type) {
                    case 1:
                        $movieType = MoviesType::where('id', $activity->idMovieType)->get()[0];
                        array_push($activity_to_push, ["name" => $movieType->name]);
                        break;
                    case 2:
                        $sport = Sports::where('id', $activity->idSport)->get()[0];
                        array_push($activity_to_push, ["name" => $sport->name]);
                        break;
                    case 3:
                        $jeux = Jeux::where('id', $activity->idJeux)->get()[0];
                        $plateforme = Plateformes::where('id', $jeux->idPlateforme)->get()[0];
                        $console = Consoles::where('id', $jeux->idConsole)->get()[0];
                        array_push($activity_to_push, ["name" => $jeux->name]);
                        break;
                    case 4 :
                        $jeux = Jeux::where('id', $activity->idJeux)->get()[0];
                        array_push($activity_to_push, ["name" => $jeux->name]);
                        break;
                    case 5:
                    case 6:
                        $sortie = Sorties::where('id', $activity->idSortie)->get()[0];
                        array_push($activity_to_push, ["name" => $sortie->name]);
                        break;
                    default:
                        $this->sendError('No object from type ' . $activity->type . ' was found');
                        break;
                }
                //array_push($array, $activity_to_push);
                $tag = new TagsModel([
                    "id" => $activity_to_push[0]["idActivity"],
                    "type" => $activity_to_push[1]['idType'],
                    'name' => $activity_to_push[2]['name']
                ]);

                array_push($returnsData, $tag);
            }
        }
        return $returnsData;
    }
}
