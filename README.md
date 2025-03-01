# Spoodler

## Quickstart

- Install [Docker](https://www.docker.com/)
- Start docker engine.
- Create an `spoodler/.env` file for secrets. E.g:

```
# DB Secrets
MYSQL_ROOT_PASSWORD = some_pass
DB_HOST = db
DB_USER = some_user
DB_PASSWORD = some_pass
DB_NAME = spoodler

APP_ENV = development

JWT_SECRET = K7rZtNfp24XRUXDG

OPENAI_API_KEY = Your_key
```

- Create your own self-signed certificates for https:

```sh
openssl req -x509 -newkey rsa:4096 -nodes -keyout docker/nginx/ssl/key.pem -out docker/nginx/ssl/cert.pem -days 365 -config "C:\Program Files\Git\usr\ssl\openssl.cnf"

openssl req -x509 -newkey rsa:4096 -nodes -keyout frontend/ssl/key.pem -out frontend/ssl/cert.pem -days 365 -config "C:\Program Files\Git\usr\ssl\openssl.cnf"
```

- Run containers:

```sh
docker-compose --env-file spoodler/.env up -d
```

- Install dependencies:

```sh
docker-compose exec php composer install
docker-compose run react npm install
```

- Recreate containers:

```sh
docker-compose --env-file spoodler/.env down
docker-compose --env-file spoodler/.env up -d
```

- Map spoodler to `127.0.0.1` in hosts file (Windows).

Then you can hit the api with a POST to `https://spoodler:8443/api/users/login`

Or you can access the UI at [spoodler:3443](https://spoodler:3443) and login with our example user:

```
email: hefesto@example.com
password: password123
```

## Running tests with Postman

1. Create an account in [Postman](https://www.postman.com/)
2. Import the [postman.json](postman/postman.json) file
3. Set up the project locally.
4. Map `spoodler` to `127.0.0.1` in hosts file (Windows).
5. Run Spoodler test suite collection

> Note: To push changes to the file export the modified collection and replace [postman.json](postman/postman.json) file.

## Running tests with PHPUnit

- Set secrets in `.env.testing`. E.g:

```
DB_HOST=test_db
DB_USER=spoodler_user
DB_PASSWORD=spoodler_password
DB_NAME=spoodler_test

APP_ENV=development

JWT_SECRET=testsecret

OPENAI_API_KEY=testkey
```

- Execute `docker-compose exec php vendor/bin/phpunit`

## Documentation

- [API REST](docs/api_endpoints.md)

- [Docker Architecture](docs/docker_architecture.md)

- [Folder Structure](docs/folder_structure.md)

- [Frontend](docs/frontend_structure.md)

- [Backend](docs/backend_structure.md)
