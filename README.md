# kuro-monsters-api
This API is about taking care of monsters.

Create a monster and be careful with this:

Every 10 minutes monsters increase their hunger by 1 and lost their energy by 5.

You have to feed them if you don't want them to die.

When hunger is at 100 they start to lose their life by 10 every 10 minutes, when life is 0 they die.

If monster lost all their energy they have to rest until they restore all their energy, meanwhile, you cannot feed them.

## Docker image

You can run this project with a [docker image](https://hub.docker.com/repository/docker/kurovale/kuro-monsters)

### Host and Bearer Token Variables

Most of the requests need a Bearer Token, you can create one with the Register request.

See the [docs](https://documenter.getpostman.com/view/20195671/Uyr4JKSB)

[![Run in Postman](https://run.pstmn.io/button.svg)](https://god.gw.postman.com/run-collection/20195671-8b08dcfe-ebb4-4d2c-8c17-e9512f77b72a?action=collection%2Ffork&collection-url=entityId%3D20195671-8b08dcfe-ebb4-4d2c-8c17-e9512f77b72a%26entityType%3Dcollection%26workspaceId%3D340d12f8-bfd8-4f84-8bc7-f3b080c24682)

### Quick Setup

You can run this web app on your machine, just follow these steps:

1. ```git clone https://github.com/kuro-vale/kuro-monsters-api.git```
2. ```cd kuro-monster-api```
3. ```composer install```
4. Create a .env, use .env.example as reference.
5. When connected your database run ```php artisan migrate``` 
6. ```php artisan serve```
7. To run scheduled jobs create a custom cron that run ```php ~/kuro-monsters-api/artisan schedule:run``` every 10 minutes
