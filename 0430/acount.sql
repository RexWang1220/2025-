CREATE DATABASE IF NOT EXISTS msgboard;
USE msgboard;

CREATE TABLE IF NOT EXISTS account (
    idno INT AUTO_INCREMENT PRIMARY KEY,
    acct VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(50) NOT NULL,
    pass VARCHAR(255) NOT NULL
);

-- 建立一個預設管理員帳號 admin / 密碼 admin123
INSERT INTO account (acct, name, pass) VALUES (
    'admin',
    '系統管理員',
    '$2y$10$UjFMfOQwFkU6U0mZK3VGj.qaz57t1y/4k2J97BfJp7E3by8ljW0tu'
);