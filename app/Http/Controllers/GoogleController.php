<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersPreferences;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
 * Create a new controller instance.
 *

     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }



    /**
     * Create a new controller instance.
     *
     * @return JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if($finduser) {
                Auth::login($finduser);
                $token =  $user->createToken('MyApp')->plainTextToken;
                return $this->sendResponse([$finduser, $token], 'Connected');
            }
            else {
                $newUser = User::create([
                    'name' => $user->name,
                    'lastName' => 'null',
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'phoneNumber'=> '',
                    'age' => 0,
                    'gender' => 'None',
                    'city' => 'None',
                    'password' => Hash::make($user->name.''.$user->id)

                ]);
                $dataUserPref = [
                    'musicStyles' => '',
                    'redFlags' => '',
                    'languages' => '',
                    'genderPref' => '',
                    'distancePref' => '',
                    'idUser' => $user->id
                ];
                $userpref = UsersPreferences::create($dataUserPref);
                $token =  $user->createToken('MyApp')->plainTextToken;
                Auth::login($newUser);

                return $this->sendResponse([$newUser, $userpref, $token], 'User created successfully');

            }
        }
        catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
