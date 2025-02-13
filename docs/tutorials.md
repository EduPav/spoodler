# Tutorials

---

## Project

### Start / restart server

Start docker engine.

Run in root project directory: (Doesn't reset state from last start of containers)
`docker-compose --env-file spoodler/.env up -d`

Access a file in spoodler folder:
http://spoodler:8080/test.php

When done changes to docker-compose restart server:
`docker-compose down && docker-compose --env-file ./spoodler/.env up -d`

### Install packages

To add a new package with composer run:
`docker-compose exec php composer require flightphp/core`
Remove with:
`docker-compose exec php composer remove flightphp/core`

---

## Bash inside php container

`docker exec -ti spoodler_php /bin/bash`

## Get container logs

`docker logs -f spoodler_php`
`docker logs -f spoodler_db`

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
all envs are in `$_ENV` and all globals in `$GLOBALS['config']`

### Run tests

`docker-compose exec php vendor/bin/phpunit`

<!-- # Most used commands -->

docker-compose --env-file ./spoodler/.env up -d
docker-compose down && docker-compose --env-file ./spoodler/.env up -d
docker-compose exec php vendor/bin/phpunit
