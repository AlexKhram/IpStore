### IpStore

Rest API for adding/getting IP4/6


GET http://localhost/rest/ip/127.0.0.1

PUT http://localhost/rest/ip/127.0.0.1 


#### How to setup:
clone project `git clone git@github.com:AlexKhram/IpStore.git`

go to IpStore/backend directory and run `cp .env.dist .env`

go to IpStore/docker directory and run `cp .env.dist .env`

in the same directory (IpStore/docker) run docker `docker-compose up -d`

install packages `docker-compose exec --user=1000:1000 php composer install`

apply migrations `docker-compose exec --user=1000:1000 php bin/console doctrine:migrations:migrate`

run test `docker-compose exec --user=1000:1000 php php bin/phpunit`

