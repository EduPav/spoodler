# Tutorials

---

## Project

### Start / restart server

Start docker engine.

Run in root project directory: (Doesn't reset state from last start of containers)
`docker-compose --env-file spoodler/.env up -d`
To restart server without losing state (for some softer updates):
`docker-compose stop && docker-compose --env-file ./spoodler/.env up -d`

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

## Bash in an exited container

`docker-compose run --rm react /bin/bash`
`docker-compose run --rm react sh`

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

## Security

### Generate self signed certificate

openssl req -x509 -newkey rsa:4096 -nodes -keyout docker/nginx/ssl/key.pem -out docker/nginx/ssl/cert.pem -days 365 -config "C:\Program Files\Git\usr\ssl\openssl.cnf"

---

## PHP

### Globals and secrets

When init.php is included in your endpoint `require_once __DIR__ . '/bootstrap/init.php';`
all envs are in `$_ENV` and all globals in `$GLOBALS['config']`

### Run tests

`docker-compose exec php vendor/bin/phpunit`

---

## Frontend

### Add new package

```sh
docker-compose exec react npm install {packageName} # Pendiente verificar este comando.
```

<!-- # Most used commands -->

docker-compose --env-file ./spoodler/.env up -d
docker-compose stop && docker-compose --env-file ./spoodler/.env up -d
docker-compose exec php vendor/bin/phpunit
