**17/05/2023**
- Adding AdminUser in DatabaseSeeder
- simpleSearch Algo. v2.1 -> Adding default list when user doesn't registered activities
- Adding AdminPanelController for User's stats
- Adding Admin Verification for Controller

**16/05/2023**
- simpleSearch Algo. v2
- premiumSearch Algo. v2
- Enhanced BlockedUserController 
- Adding duplication security to BannedUserController
- Adding duplication security to DislikesController
- Adding duplication security to SuperLikesController
- Adding duplication security to ReportedUsersController
- Begin Google Connection with https://www.itsolutionstuff.com/post/laravel-8-socialite-login-with-google-account-exampleexample.html
- Adding super like count for User's
- Adding Super like count verification in SuperLikesController
- Fix SubscriptionsController
- Adding GetAllActivities with specified Type in ActivitiesController
- Adding function to get bonus point from Premium User's
- Column Activities in User Preferences Table was Deleted

**15/05/2023**
- Adding Activities Seed
- Adding Activities SQL View
- Adding canBeSearch function to know if we can take a profile for the Search
- Adding first Algo. to search without premium filters
- Adding second Algo. to search with premium filters

**02/05/2023**
* Adding 6 Fake Default Photos to all Users in seed
* Adding Complete Seeding for Activities
* Adding some reference to table name in some Model
* 1 Column was refactored to 'name'
* Adding Messages to Swagger
* Adding Photos to Swagger

**28/04/2023 :**
* Completing Match relations when a match is deleted or like or SuperLike
* Adding Security when a User like another one to prevent duplication
* Adding launch shell script to project
* Adding Conversations to Swagger
* Adding duplication security when a conversation is created
* Adding AdminUsers to Swagger
* Adding ReportedUsers to Swagger
* Adding UserActivities to Swagger
* Adding Column with Foreign Key ('idActivity') to tables UserActivities & UserPreferencesActivities
* Adding UserPreferencesActivities to Swagger
* Adding Activities to Swagger
* Adding all api route to Activities Relations
* Adding all relations to the GET Method (Type / Game / MovieType / Sortie / Sport)
* Adding BannedUsers to Swagger

**27/04/2023 :**

* Adding Likes to Swagger
* Adding Match (Migration / Model / Controller / Swagger)
* Adding JeuxController to Swagger
* Adding UserPreferences to Swagger
* Adding Cascade Delete for all relations
* Adding WebSocket (Pusher)

**26/04/2023 :**

* Adding Swagger to Laravel Project
* Adding LoginController to Swagger
* Adding UserController to Swagger
