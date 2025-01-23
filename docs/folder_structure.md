# Project Structure

## `docker/`

Configuration files for Docker services.

```
.
├── docker
│   ├── db
│   │   ├── schema.sql
│   │   ├── seed.sql
│   └── nginx
│       └── default.conf
│   └── php
│       └── Dockerfile
```

`schema.sql`: Creates db tables. Defines the initial database schema.

`seed.sql`: Populates db tables with seed data.

`default.conf`: Configures nginx for routing and serving the application.

`Dockerfile`: Configures the PHP-FPM container for running the application. Installs composer and basic linux tools.

---

## `docs/`

Documentation for the project.

---

## `docker-compose.yml`

Defines and configures services (`nginx`, `php`, and `db`) using Docker. Includes network setup and volume mappings for local development.

---

## `spoodler/`

Main source code directory for the application. It is mounted inside the `php` container.

```
.
├── bootstrap
│   ├── config.php
│   └── init.php
├── classes
│   ├── api
│   │   ├── DbConnection.php
│   ├── report
│   │   ├── Report.php
│   └── stats
│       ├── Stats.php
├── test
│   ├── api
│   │   └── insomnia.json
│   ├── integration
│   │   └── ...
│   └── unit
│       ├── classes
│           └── ...
├── ui
│   ├── report
│   └── stats
└── vendor
  └── ...
.env
composer.json
```

`.env`: Stores environment variables such as database credentials and other **sensitive** information. These values are used by the Docker services and the application.

`composer.json`: Defines dependencies and autoloading for the application.

#### `bootstrap/`

- **`config.php`**: Contains configuration settings for the application.
- **`init.php`**: Handles initialization for every endpoint.

#### `classes/`

Organized PHP classes for different functionalities:

- **`api/`**
  - **`controller/`**:
  - **`exception/`**: Custom exception classes for handling errors.
  - **`view/`**: Handles the representation or response formatting for API calls.
- **`report/`**: Classes related to report display.
- **`stats/`**: Classes related to statistical analysis of error reports.

#### `test/`

Tests for the application.

`insomnia.json`: Insomnia collection file for API testing.

`integration/`: Integration tests for the application.

`unit/`: Unit tests for individual classes and methods.

- `classes/`: Specific unit tests for the `classes/` directory.

---

#### `ui/`

Frontend interfaces for every endpoint

---

## Additional Information

- **Dependencies**: Managed via Composer. The `composer.json` file specifies the required libraries:
  - `vlucas/phpdotenv` for environment variable management.
  - `phpunit/phpunit` for testing.
- **Network**: The Docker configuration uses a custom bridge network named `spoodler_network`.
