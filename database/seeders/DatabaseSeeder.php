<?php

namespace Database\Seeders;

use App\Models\Avantages;
use App\Models\Subscriptions;
use App\Models\SuperLikes;
use App\Models\User;
use App\Models\UsersPreferences;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        $avantage1 = [
            'canUseExtraFilter' => '1',
            'canSeeWhoLiked' => '1',
            'canReceiveDailyExtraLike' => '0',
            'canGoBack' => '0',
            'isPremiumProfil' => '0',
            'price' => '15.00',
        ];
        Avantages::create($avantage1);
        $avantage2 = [
            'canUseExtraFilter' => '1',
            'canSeeWhoLiked' => '1',
            'canReceiveDailyExtraLike' => '1',
            'canGoBack' => '0',
            'isPremiumProfil' => '1',
            'price' => '25.00',
        ];
        Avantages::create($avantage2);
        $avantage3 = [
            'canUseExtraFilter' => '1',
            'canSeeWhoLiked' => '1',
            'canReceiveDailyExtraLike' => '1',
            'canGoBack' => '1',
            'isPremiumProfil' => '1',
            'price' => '40.00',
        ];
        Avantages::create($avantage3);
        for($i = 0; $i < 500; $i++)
        {
            $gender = $faker->randomElement(['Homme', 'Autres', 'Femme', 'Femme', 'Femme', 'Homme', 'Homme', 'Homme', 'Homme', 'Homme']);

            $userData = [
                "email" => $faker->email,
                'name' => $faker->name($gender),
                'lastName' => $faker->lastName,
                'password' => Hash::make($faker->password),
                'age' => random_int(18, 35),
                'gender' => $gender,
                'phoneNumber' => $faker->phoneNumber,
                'city' => $faker->randomElement(["Mulhouse" , "Strasbourg"]),
                'description' => ' ',
            ];
            User::create($userData);
        }
        $allUsers = User::all();
        foreach($allUsers as $user) {

            $data = [
                'activities' => random_int(1, 5),
                'musicStyles' => $faker->randomElement(["Rock", "Pop", "Rap", "Jazz", "Classic"]),
                'redFlags' => $faker->randomElement(["Fumeurs", "Vegan", "Meet Eater", "Gamers", "Feminist"]),
                'languages' => $faker->randomElement(["Français", "English", "Deutsch", "Suisse"]),
                'genderPref' => $faker->randomElement(["Homme", "Femme"]),
                'distancePref' => random_int(0, 100),
                'idUser' => $user->getAttribute('id'),
            ];

            UsersPreferences::create($data);
            $calc = random_int(1, 100);
            if ($calc <= 30) {
                $avantage = Avantages::where('id', random_int(1, 3))->get();
                $data = [
                    'idUser' => $user->getAttribute('id'),
                    'timestamp' => date("y-m-d H:i"),
                    'nextCost' => date("y-m-d H:i"),
                    'idAvantage' => $avantage->first()->getAttribute('id'),
                ];
                Subscriptions::create($data);
            }
            // Super likes
            $superLikesCount = 0;
            $sub = Subscriptions::where('idUser', $user->getAttribute("id"))->get();
            $userPref = UsersPreferences::where('idUser', $user->getAttribute("id"))->get();
            if ($sub != null) {
                $superLikesCount = random_int(4, 15); // Abonnées super likes
            } else {
                $superLikesCount = random_int(1,5); // Non Abo Super Likes
            }
            for ($i = 0; $i < $superLikesCount; $i++) {
                $userToLike = null;
                $superLikes = SuperLikes::where("idUserWhoLiked", $user->getAttribute("id"))->get();
                $pass = true;
                while ($userToLike == null) {
                    $userLike = User::where("gender", $userPref->first()->getAttribute("genderPref"))->get();
                    foreach ($userLike as $userL) {
                        foreach ($superLikes as $superL) {
                            if ($superL->getAttribute("idUserWhoBeLiked") == $userL->getAttribute("id")) {
                                $pass = false;
                                break;
                            }
                        }
                        if($pass){
                            $userToLike = $userL;
                        }
                    }
                }
                $data = [
                    'idUserWhoLiked' => $user->getAttribute('id'),
                    'idUserWhoBeLiked' => $userToLike->getAttribute('id'),
                    'created_at' => date("y-m-d H:i"),
                    'updated_at' => date("y-m-d H:i"),
                ];
                SuperLikes::create($data);
            }
        }
    }
}
