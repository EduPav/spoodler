# Tutorials

---

## Project

### Start / restart server

Start docker engine.

Run in root project directory:
`docker-compose --env-file spoodler/.env up -d`

Access a file in spoodler folder:
http://spoodler:8080/test.php

When done changes to docker-compose restart server:
`docker-compose down && docker-compose --env-file ./spoodler/.env up -d`

### Install packages

To add a new package with composer run:
`docker-compose exec php composer require guzzlehttp/guzzle`
Remove with:
`docker-compose exec php composer remove guzzlehttp/guzzle`

---

## Bash inside php container

`docker exec -ti spoodler_php /bin/bash`

## db

### Connect to db

`docker exec -ti spoodler_db mysql -u <user> -p <dbName>`

test:

`docker exec -ti spoodler_test_db mysql -u spoodler_user -p spoodler_test'`
Then set password: 
`spoodler_password`
And run:
`SELECT * FROM errors;`
---

## PHP

### Globals and secrets

When init.php is included in your endpoint `require_once __DIR__ . '/bootstrap/init.php';`
all envs are in `$_ENV` and all globals in `$CONFIG`

### Run tests

`docker-compose exec php vendor/bin/phpunit`
