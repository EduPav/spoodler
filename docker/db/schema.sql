CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE errors (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    message VARCHAR(255),
    file TEXT,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL
);
