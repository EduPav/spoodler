# Project Structure

## `docker/`

Configuration files for Docker services.

```
.
└── docker
    └── db
        └── schema.sql
        └── seed.sql
    └── nginx
        └── default.conf
        └── ssl
            └── cert.pem
            └── key.pem
    └── php
        └── Dockerfile
    └── react
        └── Dockerfile
```

`db/schema.sql`: Creates db tables. Defines the initial database schema.
`db/seed.sql`: Populates db tables with seed data.

`nginx/default.conf`: Configures nginx for routing and serving the application.
`nginx/ssl`: Contains SSL certificates for secure HTTPS connections.

`php/Dockerfile`: Configures the PHP-FPM container for running the application. Installs composer and basic linux tools.

`react/Dockerfile`: Configures the React frontend container.

---

## `docs/`

Documentation for the project.

---

## `frontend/`

Main source code directory for the React frontend. It is mounted inside the `react` container.
You can find more information in [Frontend Structure](docs/frontend_structure.md) section.

---

## `spoodler/`

Main source code directory for the application. It is mounted inside the `php` container.
You can find more information in [Backend Structure](docs/backend_structure.md) section.

---

## `docker-compose.yml`

Defines and configures services (`nginx`, `php`, and `db`, `react`) using Docker. Includes network setup and volume mappings for local development.

---

## PHP Dependencies

Managed via Composer. The `composer.json` file specifies the required libraries. Main ones are:

- `vlucas/phpdotenv` for environment variable management.
- `monolog/monolog` for logging.
- `flightphp/core` for api design.
- `firebase/php-jwt` for JWT authentication.
- `openai-php/client` for OpenAI API integration.
- `phpunit/phpunit` for testing.
