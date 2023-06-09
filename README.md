<h1 style="align-self: center">You Play API</h1>

**Pré-requis :**
- Composer ([Télécharger](https://getcomposer.org/download/))
- IDE Php ([PhpStorm](https://www.jetbrains.com/fr-fr/phpstorm/download/) / [Visual Studio Code](https://code.visualstudio.com/download))
- Php
- Une base de donées MySQL

**Installation :**
- Cloner le repo [GitHub](https://github.com/iR3SH/YP_API)
- Ouvrir le projet dans PhpStorm ou Visual Studio
- Exécuter la commande _**composer install**_
- Copier le fichier .env.example et le coller en le renommant .env
- Mettre les logs de votre Base de Données
- Exécuter la commande **_php artisan key:generate_**
- Exécuter la commande **_php artisan migrate_**
- Exécuter la commande **_php artisan serve_** pour lancer l'API
- Pour générer des données fake il faut exécuter la commande **_php artisan db:seed_**
- Pour accéder à l'API via Swagger vous devez saisir l'adresse suivante après avoir lance l'API -> **127.0.0.1:8000/api/documentation**

**Comment utiliser le token d'API ?**
- Vous avez deux manières de récupérer votre token d'API
  - En vous inscrivant sur l'API
  - En vous connectant sur l'API
- Sur Postman vous devez le saire dans l'onglet Authorization puis sélectionnez le type Bearer Token et entrée le toke récupéré au préalable
- Sur Swagger cliquez sur le bouton Authorize et saissez le token
