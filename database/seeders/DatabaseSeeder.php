<?php

namespace Database\Seeders;

use App\Models\Avantages;
use App\Models\Subscriptions;
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

    /*
     * SQL Sentences to Keep Data
        SELECT
            users.`name`,
            users.lastName,
            users.email,
            users.`password`,
            users.gender,
            users.phoneNumber,
            users.city,
            users_preferences.activities,
            users_preferences.musicStyles,
            users_preferences.redFlags,
            users_preferences.languages,
            users_preferences.moviePref,
            users_preferences.genderPref,
            users_preferences.distancePref
        FROM
            users,
            users_preferences
        WHERE
            users_preferences.idUser = users.id
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');

        for($i = 0; $i < 500; $i++)
        {
            $gender = $faker->randomElement(['Homme', 'Autres', 'Femme', 'Femme', 'Femme', 'Homme', 'Homme', 'Homme', 'Homme', 'Homme']);
            //$gender = $faker->randomElement(['Autres']);
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
        foreach($allUsers as $user)
        {

            $data = [
                'activities' => $faker->randomElement(["Distanciel" , "Présentiel", "Présentiel", "Présentiel"]),
                'musicStyles' => $faker->randomElement(["Rock" , "Pop", "Rap", "Jazz", "Classic"]),
                'redFlags' => $faker->randomElement(["Fumeurs" , "Vegan", "Meet Eater", "Gamers", "Feminist"]),
                'languages' => $faker->randomElement(["Français" , "English", "Deutsch", "Suisse"]),
                'genderPref' => $faker->randomElement(["Homme" , "Femme"]),
                'distancePref' => random_int(0, 100),
                'idUser' => $user->getAttribute('id'),
            ];

            UsersPreferences::create($data);
            $avantage = Avantages::where('id', random_int(1,4))->get();
            $data = [
                'idUser'=> $user->getAttribute('id'),
                'timestamp' => date("y-m-d H:i"),
                'nextCost' => date("y-m-d H:i"),
                'idAvantage' => $avantage->first()->getAttribute('id'),
            ];
            Subscriptions::create($data);
        }
    }
}
