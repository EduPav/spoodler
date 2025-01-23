# Tasks

## Pending

- Complete DbClasses. Chat with chatGPT ongoing.
  - Complete DbConnection and test it (DONE)
  - Add base model class (CRUD) and its tests (continue main chat in pfe project with gpt4)
  - Add specific models
- Autoenvío de errores

### DbConnection

- Modify the throw so it uses ServerException or sth more appropriate to the ones we use in the original project.

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
