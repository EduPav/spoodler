# Tasks

## Pending

- Create RESTful report and reports endpoints. WIth full crud? routes? learn structure.
- UI with 3 pages. Home with all reports, Single report page and stats one.
- Html view and its tests

---

## Professor requirements:

- RESTful API.
- Some sort of security. ssl certs? Multifactor auth?
- user, and i guess also passwords, databases.
- stats endpoint for graphical and statistical analysis.
- Insomnia testing (not required by him, but wants different types of tests).

---

## Done

- Create lib with functions to handle user input. Create those with chatGPT to get
  different code than original.
- Implement example endpoint. (LegacyHandler.php, report.php)
- Add MVC classes tests.
- Implement my PFE MVC classes
- Increase table classes robustness
- Set up logger:
  - Save general uncaught errors and exceptions to db. (classes LoggerBuilder and PDOHandler)
  - Save caught exceptions to db (classes LoggerBuilder and PDOHandler)
  - tests for PDOHandler
- Fix using test and dev same db.
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
