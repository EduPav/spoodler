# Tasks

## Pending

- Autoenvío de errores.

---

## Professor requirements:

- Add deleted endpoint as an example to the official pdf report?
- RESTful API.
- Some sort of security. ssl certs? Multifactor auth?
- user, and i guess also passwords, databases.
- stats endpoint for graphical and statistical analysis.

- Decidido levantar una db toda con datos artificiales. Y que se pierdan los agregados en una ejecución específica.

---

## Done

- Complete DbClasses
  - Complete DbConnection and test it (DONE)
  - Add base model class (CRUD) and its tests (DONE)
  - Add specific models and their tests(DONE)
- Use a different db for testing
- Create exceptions structure based on original project. Only use needed ones.
- Set phpunit. Continue tutorial of last chat with chatgpt. I have an error when running this with the example class hello
  docker-compose exec php vendor/bin/phpunit
- Populate db tables with examples in seed.
- Set composer
- Create an initialization script.
- Load env file
- Create a .env file
- Create a global configs file
- You can access spoodler in spoodler:8080
- Set up with docker-compose: php, nginx, mysql working containers.
