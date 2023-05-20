<?php

namespace Database\Seeders;

use App\Models\Activities;
use App\Models\ActivitiesType;
use App\Models\AdminUsers;
use App\Models\Avantages;
use App\Models\Consoles;
use App\Models\Jeux;
use App\Models\MoviesType;
use App\Models\Photos;
use App\Models\Plateformes;
use App\Models\Sorties;
use App\Models\Sports;
use App\Models\Subscriptions;
use App\Models\SuperLikes;
use App\Models\User;
use App\Models\UsersActivities;
use App\Models\UsersPreferences;
use App\Models\UsersPrefsActivities;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
                "email" => $faker->unique()->email,
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
        // Plateformes
        Plateformes::create([
            'name' => 'Indépendant'
        ]);
        Plateformes::create([
            'name' => 'Steam'
        ]);
        Plateformes::create([
            'name' => 'Origine'
        ]);
        Plateformes::create([
            'name' => 'GoG'
        ]);
        Plateformes::create([
            'name' => 'Nintendo'
        ]);
        Plateformes::create([
            'name' => 'Sega'
        ]);
        Plateformes::create([
            'name' => 'EA'
        ]);
        Plateformes::create([
            'name' => 'Ubisoft'
        ]);
        Plateformes::create([
            'name' => 'Valve'
        ]);
        Plateformes::create([
            'name' => 'Offline'
        ]);

        // Console
        Consoles::create([
            'name' => 'Nintendo'
        ]);
        Consoles::create([
            'name' => 'Xbox'
        ]);
        Consoles::create([
            'name' => 'Playstation'
        ]);
        Consoles::create([
        'name' => 'PC'
        ]);
        Consoles::create([
            'name' => 'Stadia'
        ]);
        Consoles::create([
            'name' => 'Offline'
        ]);

        // Games
        Jeux::create([
            'name' => 'Dofus',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'LoL',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'The Witcher',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Minecraft',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Final Fantasy',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'The Elder Scroll',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Rainbow Six Siege',
            'idConsole' => '4',
            'idPlateforme' => '2'
        ]);
        Jeux::create([
            'name' => 'Among Us',
            'idConsole' => '4',
            'idPlateforme' => '2'
        ]);
        Jeux::create([
            'name' => 'Rocket League',
            'idConsole' => '4',
            'idPlateforme' => '2'
        ]);
        Jeux::create([
            'name' => 'FIFA',
            'idConsole' => '3',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'GTA',
            'idConsole' => '2',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Fortnite',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Apex Legends',
            'idConsole' => '4',
            'idPlateforme' => '7'
        ]);
        Jeux::create([
            'name' => 'Call of Duty',
            'idConsole' => '4',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Counter Strike',
            'idConsole' => '4',
            'idPlateforme' => '2'
        ]);
        Jeux::create([
            'name' => 'NBA',
            'idConsole' => '4',
            'idPlateforme' => '2'
        ]);
        Jeux::create([
            'name' => 'Clash Royale',
            'idConsole' => '5',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'PUBG',
            'idConsole' => '5',
            'idPlateforme' => '1'
        ]);
        Jeux::create([
            'name' => 'Mario Kart',
            'idConsole' => '1',
            'idPlateforme' => '5'
        ]);

        // Jeux Offline
        Jeux::create([
            'name' => 'UNO',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'Monopoly',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'Loup Garou',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'Échecs',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'Jungle Speed',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'Twister',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);
        Jeux::create([
            'name' => 'JDR',
            'idConsole' => '6',
            'idPlateforme' => '10'
        ]);

        //Sports
        Sports::create([
           'name' => 'Kayak'
        ]);
        Sports::create([
            'name' => 'Judo'
        ]);
        Sports::create([
            'name' => 'Badminton'
        ]);
        Sports::create([
            'name' => 'Tennis'
        ]);
        Sports::create([
            'name' => 'Basket'
        ]);
        Sports::create([
            'name' => 'Equitation'
        ]);
        Sports::create([
            'name' => 'Volley-ball'
        ]);
        Sports::create([
            'name' => 'Pétanque'
        ]);
        Sports::create([
            'name' => 'Natation'
        ]);
        Sports::create([
            'name' => 'Karaté'
        ]);
        Sports::create([
            'name' => 'Ping-pong'
        ]);
        Sports::create([
            'name' => 'Tire à l’arc'
        ]);
        Sports::create([
            'name' => 'Football'
        ]);
        Sports::create([
            'name' => 'Foot à 5'
        ]);
        Sports::create([
            'name' => 'Aqua poney'
        ]);

        // Sorties (Jours)
        Sorties::create([
           'name' => 'Bowling'
        ]);
        Sorties::create([
            'name' => 'Bar'
        ]);
        Sorties::create([
            'name' => 'Café'
        ]);
        Sorties::create([
            'name' => 'Resto'
        ]);
        Sorties::create([
            'name' => 'Match de foot'
        ]);
        Sorties::create([
            'name' => 'Aller au stade'
        ]);

        // Sorties (Nuit)
        Sorties::create([
            'name' => 'Bar'
        ]);
        Sorties::create([
            'name' => 'Bar à jeux'
        ]);
        Sorties::create([
            'name' => 'Disco'
        ]);
        Sorties::create([
            'name' => 'Karaoké'
        ]);
        Sorties::create([
            'name' => 'Match de foot'
        ]);
        Sorties::create([
            'name' => 'Strip-clubs'
        ]);
        Sorties::create([
            'name' => 'Soirée Alcoolisé'
        ]);
        Sorties::create([
            'name' => 'Casino'
        ]);
        Sorties::create([
            'name' => 'Parties fines'
        ]);
        Sorties::create([
            'name' => 'Resto'
        ]);
        Sorties::create([
            'name' => 'Opéra'
        ]);
        Sorties::create([
            'name' => 'Théâtre'
        ]);

        // Genre de Film
        MoviesType::create([
            'name' => 'Comédie'
        ]);
        MoviesType::create([
            'name' => 'Drame'
        ]);
        MoviesType::create([
            'name' => 'Thriller'
        ]);
        MoviesType::create([
            'name' => 'Action'
        ]);
        MoviesType::create([
            'name' => 'Horreur'
        ]);
        MoviesType::create([
            'name' => 'Science-fiction'
        ]);
        MoviesType::create([
            'name' => 'Fantasy'
        ]);
        MoviesType::create([
            'name' => 'Western'
        ]);
        MoviesType::create([
            'name' => 'Dessin animé'
        ]);
        MoviesType::create([
            'name' => 'Romance'
        ]);
        MoviesType::create([
            'name' => 'Historique'
        ]);
        MoviesType::create([
            'name' => 'Criminel'
        ]);
        MoviesType::create([
            'name' => 'Dystopie'
        ]);
        MoviesType::create([
            'name' => 'Erotique'
        ]);
        MoviesType::create([
            'name' => 'Animé Japonais'
        ]);

        // Type Activities
        ActivitiesType::create([
            'name' => 'Genre de film'
        ]);
        ActivitiesType::create([
            'name' => 'Sports'
        ]);
        ActivitiesType::create([
            'name' => 'Jeux Online'
        ]);
        ActivitiesType::create([
            'name' => 'Jeux Offlines'
        ]);
        ActivitiesType::create([
            'name' => 'Activités'
        ]);
        ActivitiesType::create([
            'name' => 'Activités Nocturnes'
        ]);

        //Activities
            // Genre Film
            Activities::create([
                'type' => '1',
                'idMovieType' => '1'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '2'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '3'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '4'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '5'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '6'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '7'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '8'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '9'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '10'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '11'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '12'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '13'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '14'
            ]);
            Activities::create([
                'type' => '1',
                'idMovieType' => '15'
            ]);
            // Sports
            Activities::create([
                'type' => '2',
                'idSport' => '1'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '2'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '3'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '4'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '5'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '6'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '7'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '8'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '9'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '10'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '11'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '12'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '13'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '14'
            ]);
            Activities::create([
                'type' => '2',
                'idSport' => '15'
            ]);
            // Jeux Online
            Activities::create([
                'type' => '3',
                'idJeux' => '1'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '2'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '3'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '4'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '5'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '6'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '7'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '8'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '9'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '10'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '11'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '12'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '13'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '14'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '15'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '16'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '17'
            ]);
            Activities::create([
                'type' => '3',
                'idJeux' => '18'
            ]);
            // Jeux Offline
            Activities::create([
                'type' => '4',
                'idJeux' => '19'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '20'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '21'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '22'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '23'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '24'
            ]);
            Activities::create([
                'type' => '4',
                'idJeux' => '25'
            ]);
            // Sorties (Jour)
            Activities::create([
                'type' => '5',
                'idSortie' => '1'
            ]);
            Activities::create([
                'type' => '5',
                'idSortie' => '2'
            ]);
            Activities::create([
                'type' => '5',
                'idSortie' => '3'
            ]);
            Activities::create([
                'type' => '5',
                'idSortie' => '4'
            ]);
            Activities::create([
                'type' => '5',
                'idSortie' => '5'
            ]);
            Activities::create([
                'type' => '5',
                'idSortie' => '6'
            ]);
            // Sortie Nocturnes
            Activities::create([
                'type' => '6',
                'idSortie' => '7'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '8'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '9'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '10'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '11'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '12'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '13'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '14'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '15'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '16'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '17'
            ]);
            Activities::create([
                'type' => '6',
                'idSortie' => '18'
            ]);

            // Users pics
        foreach($allUsers as $usr){
            Photos::create([
                'fileName' => 'utilisateur1.png',
                'position' => '1',
                'idUser' => $usr->getAttribute('id')
            ]);
            Photos::create([
                'fileName' => 'utilisateur2.png',
                'position' => '2',
                'idUser' => $usr->getAttribute('id')
            ]);
            Photos::create([
                'fileName' => 'utilisateur3.png',
                'position' => '3',
                'idUser' => $usr->getAttribute('id')
            ]);
            Photos::create([
                'fileName' => 'utilisateur4.png',
                'position' => '4',
                'idUser' => $usr->getAttribute('id')
            ]);
            Photos::create([
                'fileName' => 'utilisateur5.png',
                'position' => '5',
                'idUser' => $usr->getAttribute('id')
            ]);
            Photos::create([
                'fileName' => 'utilisateur6.png',
                'position' => '6',
                'idUser' => $usr->getAttribute('id')
            ]);

            // Users Activities

            $arrayIdInt = [];
            $randomNbActivities = random_int(1, 15);
            for($i = 0; $i < $randomNbActivities; $i++){
                $numb = random_int(1, 73);
                while(in_array($numb, $arrayIdInt)){
                    $numb = random_int(1, 73);
                }
                array_push($arrayIdInt, $numb);
            }
            foreach($arrayIdInt as $idActivity){
                UsersActivities::create([
                    'idUser' => $usr->getAttribute('id'),
                    'idActivity' => $idActivity
                ]);
            }
            //Premium Filters
            $chanceToHavePremiumFilter = random_int(1, 100);
            if ($chanceToHavePremiumFilter < 30){
                $rand1_5 = random_int(1, 5);
                $arrayIds = [];
                for($i = 0; $i < $rand1_5; $i++)
                {
                    $numb = random_int(1, 73);
                    while(in_array($numb, $arrayIds)){
                        $numb = random_int(1, 73);
                    }
                    array_push($arrayIds, $numb);
                }

                foreach($arrayIds as $id){
                    $userPref = UsersPreferences::where('idUser', $id)->get()[0];
                    UsersPrefsActivities::create([
                        'idUserPref' => $userPref->getAttribute('id'),
                        'idActivity' => $id
                    ]);
                }
            }
        }
        $adminUser = User::create([
            'email' => 'admin@you-play.fr',
            'name'  => 'admin',
            'lastName' => 'YouPlay',
            'password' => Hash::make('1234'),
            'phoneNumber' => '0685478548',
            'gender' => 'Homme',
            'city' => 'Strasbourg',
            'age' => '90'
        ]);

        UsersPreferences::create([
            'musicStyles' => 'Rock',
            'redFlags' => 'Fornite',
            'languages' => 'Français',
            'genderPref' => 'Femme',
            'distancePref' => '50',
            'idUser' => $adminUser->id
        ]);

        AdminUsers::create([
           'idUser' => $adminUser->id,
           'grantedBy' => $adminUser->id
        ]);
        Subscriptions::create([
            'idUser' => $adminUser->id,
            'timestamp' => date("y-m-d H:i"),
            'nextCost' => date("y-m-d H:i"),
            'idAvantage' => 3
        ]);
    }
}
