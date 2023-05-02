<?php

namespace App\Http\Controllers;

use App\Models\AdminUsers;
use App\Models\BannedUsers;
use App\Models\Conversations;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="YP API", version="0.1"),
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
}
