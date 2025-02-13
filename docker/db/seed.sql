-- Populate the `users` table.
INSERT INTO users (email, password) VALUES
('alice.johnson@example.com', 'password123'),
('bob.smith@example.com', 'password456'),
('charlie.brown@example.com', 'password789'),
('diana.prince@example.com', 'passwordabc'),
('ethan.hunt@example.com', 'passwordxyz');

-- Populate the `errors` table. Eventually replace by examples of real local project errors.
INSERT INTO errors (message, file, description, created_at) VALUES
('Null pointer exception', 'classes/Controller/UserController.php', 'Occurs when trying to access a property of a null object.', '2023-08-01 10:00:00'),
('Database connection failed', 'classes/Database/Connection.php', 'Happens when the database credentials are incorrect or the server is unreachable.', '2023-08-01 10:00:00'),
('Undefined index', 'classes/Service/ErrorHandler.php', 'Triggered when accessing a non-existent array key.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'SUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUPER LONG FILE', 'Caused by a missing semicolon in the template.', '2023-08-01 10:00:00'),
('Syntax error', 'classes/View/TemplateRenderer.php', 'SUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUPER LONG DESCRIPTION', '2023-08-01 10:00:00');

