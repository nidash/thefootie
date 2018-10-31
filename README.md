[![CircleCI](https://circleci.com/gh/nidash/thefootie.svg?style=svg)](https://circleci.com/gh/nidash/thefootie)
###The Footie App
##Usage:
Please checkout from github link https://github.com/nidash/thefootie
1) Install docker if not installed already.
2) composer install
3) Copy .env.dist to .env 
4) Start up a database server, see compose file environment variables are coming and can be overridden in .env file. Currently we are using port 3306 but this can be changed.
   
    docker-compose up -d
   
   This will create new database called footie and footie_testing (using thefootie.sql)
   
   This is using official mysql 5.7 docker images
   
   If you change port numbers please change in DATABASE_URL in the .env and phpunit.xml as well. 
    
4) Create schema like so - ./bin/console doctrine:migrations:execute 20181026113305
5) Run fixtures - ./bin/console doctrine:fixtures:load
6) Run server - ./bin/console server:run
7) Use postman to try the following
   
   GET /leagues - will get all leagues
   
   GET /leagues/1 - will get league with id 1
   
   PUT /leagues/1 - send json encoded payload eg. {"name":"abc"} will update the record
   
   DELETE /leagues/1 - will delete record with id 1
   
   GET /teams - will get all teams
   
   GET /teams/1 - will get team with id 1
   
   PUT /teams/1 - send json encoded payload eg.  {"name":"abc", "strip":"something"} will update record.
   
   DELETE /teams/1 - will delete record with id 1
   
   
##Notes:
To run tests ./bin/phpunit
