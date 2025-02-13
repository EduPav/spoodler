# Tasks

## Pending

- Fix not found page when reaching a weird route through api. It should be structured json.
- Add pagination? Fill more values in sample db for experiments with UI.
- Create statistics page.
- Tengo seteado not null a description, pero con throw de Internals en ErrorLogHandler me salieron sin description.

---

## Professor requirements:

- Some sort of security. ssl certs? Multifactor auth?
- user, and i guess also passwords, databases.
- stats endpoint for graphical and statistical analysis.
- Insomnia testing (not required by him, but wants different types of tests).

---

## Done

- Remove internaltest routing (for 500 page tests)
- React: Route to internal error when error comes from api.
- REact: fix when visiting home errors is not bold
- make sure for long descriptions ErrorTable doesn't break. Limit chars or vertical size.
- Create single report page.
- 404 and generic error pages.
- UI: All Errors Done
- Research REACT usage basics
- RESTful API:
  - public folder, basic index.php file and Router.php
  - Read basics of the library in its page. Request and Response specially. Also HTMl section
  - Create a Controller class, or auxiliar one, to send the code and error handling there? So functions become methods
  - Avoid using static methods
  - Handle user input in the controller
  - Add tests for all classes
  - Create RESTful report and reports endpoints.
- Remove public from functions
- Create lib with functions to handle user input. Create those with chatGPT to get different code than original.
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
