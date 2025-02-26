-- Populate the `users` table.
INSERT INTO users (email, password) VALUES
('hefesto@example.com', '$2a$04$g9X23UcRmKjPN4rk/K7Q9ORaGGOUWFzZgx21UfppjkIZtRuF/zmRO'), -- password123
('bob.smith@example.com', '$2a$04$amjNgOGd3kA910KuP87pMetBlQcE.mgchT83XshuZKgq6WK0EdzqK'), -- password456
('charlie.brown@example.com', '$2a$04$g9X23UcRmKjPN4rk/K7Q9ORaGGOUWFzZgx21UfppjkIZtRuF/zmRO'), -- password123
('diana.prince@example.com', '$2a$04$amjNgOGd3kA910KuP87pMetBlQcE.mgchT83XshuZKgq6WK0EdzqK'), -- password456
('ethan.hunt@example.com', '$2a$04$amjNgOGd3kA910KuP87pMetBlQcE.mgchT83XshuZKgq6WK0EdzqK'); -- password456

-- Populate the `errors` table.
INSERT INTO errors (message, file, description, created_at) VALUES
('Null pointer exception', 'classes/Controller/UserController.php', 'Occurs when trying to access a property of a null object.', '2023-08-01 10:00:00'),
('Database connection failed', 'classes/Database/Connection.php', 'Happens when the database credentials are incorrect or the server is unreachable.', '2023-08-01 10:00:00'),
('Undefined index', 'classes/Service/ErrorHandler.php', 'Triggered when accessing a non-existent array key.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'SUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUPER LONG FILE', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'SUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUPER LONG DESCRIPTION', '2023-08-01 10:00:00'),
('Undetermined', 'Undetermined', 'Uncaught Exception ArgumentCountError: "Too few arguments to function classes\api\handler\ErrorLogHandler::__construct(), 2 passed in /var/www/html/classes/api/Router.php on line 25 and exactly 3 expected" at /var/www/html/classes/api/handler/ErrorLogHandler.php line 16', ' 2025-02-18 16:53:17'),
('Error when accessing endpoint', 'vendor/openai-php/client/src/Transporters/HttpTransporter.php', 'Incorrect API key provided: abcdef. You can find your API key at https://platform.openai.com/account/api-keys.', '2025-02-18 16:59:33' ),
('Error when accessing endpoint', 'classes/api/handler/ErrorLogHandler.php', 'Too few arguments to function classes\api\handler\ErrorLogHandler::__construct(), 2 passed in /var/www/html/classes/api/Router.php on line 28 and exactly 3 expected', '2025-02-18 17:56:07'),
('Error when accessing endpoint', 'classes/advice/OpenAIAdviceProvider.php', 'OpenAI API key not found.', '2025-02-18 19:41:52'),
('Error when accessing endpoint', 'vendor/openai-php/client/src/Transporters/HttpTransporter.php', 'Incorrect API key provided: ask-proj*********************************************************************************************************************************************************QaQA. You can find your API key at https://platform.openai.com/account/api-keys.', '2025-02-19 16:54:16'),
('Error when accessing endpoint', 'classes/advice/OpenAIAdviceProvider.php', 'AI Advices are disabled.', '2025-02-19 17:19:29');


-- ('Error when accessing endpoint', '', '', '');

