<?php

namespace Database\Seeders;

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
        $faker = Faker::create();
        for($i = 0; $i < 1000; $i++)
        {
            $gender = $faker->randomElement(['Male', 'Others', 'Female', 'Female', 'Female', 'Male', 'Male', 'Male', 'Male', 'Male']);
            $userData = [
                "email" => $faker->email,
                'name' => $faker->name($gender),
                'lastName' => $faker->lastName,
                'password' => Hash::make($faker->password),
                'gender' => $gender,
                'phoneNumber' => $faker->phoneNumber,
                'city' => $faker->randomElement(["Mulhouse" , "Strasbourg"]),
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
                'genderPref' => $faker->randomElement(["Mâle" , "Female"]),
                'distancePref' => random_int(0, 100),
                'idUser' => $user->getAttribute('id'),
            ];

            UsersPreferences::create($data);
        }
    }
}
