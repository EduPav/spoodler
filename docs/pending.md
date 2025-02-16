# Tasks

## Pending

- Create statistics page.
- Bugs:
  - Method not allowed api error is not json standard.
  - Fix not found page when reaching a weird route through api. It should be structured json.
  - Tengo seteado not null a description, pero con throw de Internals en ErrorLogHandler me salieron sin description.
  - Couldn't add ssl cert to default authorized for windows. Had to approve in browser but throws it says "page is insecure"
  - Db connection error is not handled. Fatal error.
  - REACT: when visiting invalid id in errors/id page it shows empty page, not an error.
- Add pagination? Fill more values in sample db for experiments with UI.
- REACT: Create login page
- REACT: Add authentication to backend.
- test postman.json import

---

## Professor requirements:

- stats endpoint for graphical and statistical analysis.

---

## Done

- Postman:
  - Add tests for all endpoints.
  - Save them in tests/api (tested export)
- Add user functionality:
  - user model
  - JWT
  - user authentication
  - Require JWT for using most methods. All error routes and user/getMe for example.
  - Add tests for all new user related classes and methods
- Add tls/ssl to nginx config (Professor required some sort of security. ssl certs? Multifactor auth?)
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
