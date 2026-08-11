CREATE DATABASE IF NOT EXISTS happy_paws_db;

USE happy_paws_db;

CREATE TABLE users (

    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)

);