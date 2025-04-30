CREATE DATABASE IF NOT EXISTS msgboard DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE msgboard;
CREATE TABLE IF NOT EXISTS account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    acc VARCHAR(100) NOT NULL UNIQUE,   
    pass VARCHAR(255) NOT NULL,         
    name VARCHAR(100) NOT NULL          
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO account (acc, pass, name) VALUES (
    'testuser',
    '$2y$10$O5gKnlEL0bkIVvY3Zho3N.Ve3qUhdBaEIoIK9yzYDD.VsEQPfUbXm',
    '測試使用者'
);
