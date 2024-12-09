# Tutorials

To add a new package with composer run:
`docker-compose exec php composer require guzzlehttp/guzzle`
Remove with:
`docker-compose exec php composer remove guzzlehttp/guzzle`

I could access a file in spoodler folder like this:
http://spoodler:8080/test.php

When done changes to docker-compose:
`docker-compose down && docker-compose up -d`

When included init.php, then all envs are in $\_ENV and all globals in $config

# Done

- Set up with docker-compose: php, nginx, mysql working containers.
- You can access spoodler in spoodler:8080
- Create a global configs file
- Create a .env file (where?)
- Load env file
- Create an initialization script.
- Set composer

# Pending

-
- Make sure db class is testable. (integrations?)
- Accomplish CRUD with DB
- Set phpunit

- Create exceptions structure based on original project. Only use needed ones.

## DbConnection

- Modify the throw so it uses ServerException or sth more appropriate to
  the ones we use in the original project.
