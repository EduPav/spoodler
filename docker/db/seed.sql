-- Populate the `users` table.
INSERT INTO users (name, email) VALUES
('Alice Johnson', 'alice.johnson@example.com'),
('Bob Smith', 'bob.smith@example.com'),
('Charlie Brown', 'charlie.brown@example.com'),
('Diana Prince', 'diana.prince@example.com'),
('Ethan Hunt', 'ethan.hunt@example.com');

-- Populate the `errors` table. Eventually replace by examples of real local project errors.
INSERT INTO errors (message, file, description) VALUES
('Null pointer exception', '/var/www/html/src/Controller/UserController.php', 'Occurs when trying to access a property of a null object.'),
('Database connection failed', '/var/www/html/src/Database/Connection.php', 'Happens when the database credentials are incorrect or the server is unreachable.'),
('Undefined index', '/var/www/html/src/Service/ErrorHandler.php', 'Triggered when accessing a non-existent array key.'),
('Syntax error', '/var/www/html/src/View/TemplateRenderer.php', 'Caused by a missing semicolon in the template.');

