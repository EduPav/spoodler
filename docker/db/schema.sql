CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL
);

CREATE TABLE errors (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    message VARCHAR(255),
    file VARCHAR(255),
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL
);
